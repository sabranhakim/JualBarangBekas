<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class MidtransService
{
    private string $baseUrl;
    private ?string $serverKey;

    public function __construct()
    {
        $isProduction = (bool) config('services.midtrans.is_production');
        $this->baseUrl = $isProduction
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
        $this->serverKey = config('services.midtrans.server_key');
    }

    public function createSnapTransaction(Order $order, Product $product): array
    {
        if (empty($this->serverKey)) {
            throw ValidationException::withMessages([
                'payment' => 'Konfigurasi MIDTRANS_SERVER_KEY belum diatur.',
            ]);
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $order->payment_reference,
                'gross_amount' => (int) $product->price,
            ],
            'item_details' => [[
                'id' => (string) $product->id,
                'price' => (int) $product->price,
                'quantity' => 1,
                'name' => mb_substr($product->name, 0, 50),
            ]],
            'customer_details' => [
                'first_name' => $order->receiver_name,
                'email' => $order->user->email,
                'phone' => $order->phone,
            ],
            'callbacks' => [
                'finish' => route('marketplace.transactions'),
                'unfinish' => route('marketplace.transactions'),
                'error' => route('marketplace.transactions'),
            ],
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->acceptJson()
            ->post($this->baseUrl . '/snap/v1/transactions', $payload);

        if (! $response->successful()) {
            throw ValidationException::withMessages([
                'payment' => 'Gagal membuat transaksi pembayaran. Coba beberapa saat lagi.',
            ]);
        }

        return $response->json();
    }

    public function isSignatureValid(array $payload): bool
    {
        if (empty($this->serverKey)) {
            return false;
        }

        if (! isset($payload['signature_key'], $payload['order_id'], $payload['status_code'], $payload['gross_amount'])) {
            return false;
        }

        $expected = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $this->serverKey);

        return hash_equals($expected, (string) $payload['signature_key']);
    }
}
