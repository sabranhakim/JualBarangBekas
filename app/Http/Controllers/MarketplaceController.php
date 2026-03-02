<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MarketplaceController extends Controller
{
    public function __construct(private MidtransService $midtrans)
    {
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $products = Product::with(['category', 'images', 'user'])
            ->where('status', 'tersedia')
            ->where('user_id', '!=', Auth::id())
            ->when($q, fn($query) => $query->where('name', 'like', '%' . $q . '%'))
            ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();

        return view('marketplace.index', compact('products', 'categories', 'q', 'categoryId'));
    }

    public function checkout(Product $product)
    {
        abort_if($product->status !== 'tersedia' || $product->user_id === Auth::id(), 404);

        $product->load(['category', 'images', 'user']);

        return view('marketplace.checkout', compact('product'));
    }

    public function storeOrder(Request $request, Product $product)
    {
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'note' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:1|max:1',
        ]);

        abort_if($product->user_id === Auth::id(), 403, 'Anda tidak bisa membeli produk milik sendiri.');

        try {
            $order = DB::transaction(function () use ($validated, $product) {
                $freshProduct = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();

                abort_if($freshProduct->status !== 'tersedia', 422, 'Produk sudah tidak tersedia.');

                $alreadyReserved = OrderItem::query()
                    ->where('product_id', $freshProduct->id)
                    ->whereHas('order', function ($query) {
                        $query->whereIn('status', ['pending', 'paid', 'shipped', 'completed']);
                    })
                    ->exists();

                abort_if($alreadyReserved, 422, 'Produk sedang diproses transaksi lain.');

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'receiver_name' => $validated['receiver_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'note' => $validated['note'] ?? null,
                    'status' => 'pending',
                    'payment_gateway' => 'midtrans',
                ]);

                $order->update([
                    'payment_reference' => 'ORD-' . $order->id . '-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5)),
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $freshProduct->id,
                    'quantity' => 1,
                    'price' => $freshProduct->price,
                ]);

                // Reserve produk sampai pembayaran sukses atau dibatalkan.
                $freshProduct->update(['status' => 'terjual']);

                return $order;
            });

            $order->load('user');
            $paymentResponse = $this->midtrans->createSnapTransaction($order, $product);

            $order->update([
                'payment_url' => $paymentResponse['redirect_url'] ?? null,
                'payment_payload' => $paymentResponse,
            ]);
        } catch (ValidationException $exception) {
            if (isset($order)) {
                $order->update(['status' => 'cancelled']);
                $this->releaseProductIfNeeded($order);
            }

            throw $exception;
        } catch (\Throwable $exception) {
            if (isset($order)) {
                $order->update(['status' => 'cancelled']);
                $this->releaseProductIfNeeded($order);
            }

            return back()->withErrors(['payment' => 'Gagal memproses transaksi. Silakan coba lagi.']);
        }

        if (! $order->payment_url) {
            return redirect()->route('marketplace.transactions')
                ->withErrors(['payment' => 'Link pembayaran belum tersedia.']);
        }

        return redirect()->away($order->payment_url);
    }

    public function handleMidtransNotification(Request $request): JsonResponse
    {
        $payload = $request->all();

        if (! $this->midtrans->isSignatureValid($payload)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = $this->findOrderFromMidtransPayload($payload);
        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        $newStatus = match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? 'paid' : 'pending',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'cancelled',
            default => $order->status,
        };

        DB::transaction(function () use ($order, $newStatus, $payload) {
            $updatePayload = [
                'status' => $newStatus,
                'payment_payload' => $payload,
            ];

            if ($newStatus === 'paid') {
                $updatePayload['paid_at'] = now();
            }

            $order->update($updatePayload);

            $item = $order->items()->first();
            if (! $item) {
                return;
            }

            if (in_array($newStatus, ['paid', 'shipped', 'completed'], true)) {
                Product::whereKey($item->product_id)->update(['status' => 'terjual']);
            }

            if ($newStatus === 'cancelled') {
                $this->releaseProductByIdIfPossible($item->product_id);
            }
        });

        return response()->json(['message' => 'ok']);
    }

    public function transactions()
    {
        $orders = Order::with(['items.product.images', 'items.product.category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('marketplace.transactions', compact('orders'));
    }

    public function retryPayment(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'pending', 422, 'Hanya transaksi pending yang bisa dibayar ulang.');

        if (! $order->payment_reference) {
            $order->update([
                'payment_reference' => 'ORD-' . $order->id . '-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5)),
            ]);
        }

        if ($order->payment_url) {
            return redirect()->away($order->payment_url);
        }

        $item = $order->items()->with('product')->firstOrFail();
        $order->load('user');

        $paymentResponse = $this->midtrans->createSnapTransaction($order, $item->product);
        $order->update([
            'payment_url' => $paymentResponse['redirect_url'] ?? null,
            'payment_payload' => $paymentResponse,
        ]);

        if (! $order->payment_url) {
            return redirect()->route('marketplace.transactions')
                ->withErrors(['payment' => 'Link pembayaran belum tersedia.']);
        }

        return redirect()->away($order->payment_url);
    }

    private function findOrderFromMidtransPayload(array $payload): ?Order
    {
        $reference = $payload['order_id'] ?? null;
        if (! $reference) {
            return null;
        }

        return Order::where('payment_reference', $reference)->first();
    }

    private function releaseProductIfNeeded(Order $order): void
    {
        $item = $order->items()->first();
        if (! $item) {
            return;
        }

        $this->releaseProductByIdIfPossible($item->product_id);
    }

    private function releaseProductByIdIfPossible(int $productId): void
    {
        $hasActiveOrder = OrderItem::query()
            ->where('product_id', $productId)
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['pending', 'paid', 'shipped', 'completed']);
            })
            ->exists();

        if (! $hasActiveOrder) {
            Product::whereKey($productId)->update(['status' => 'tersedia']);
        }
    }
}
