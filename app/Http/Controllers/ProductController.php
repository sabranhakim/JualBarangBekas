<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Feedback;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function showAll(Request $request)
    {
        // Ambil query dari URL
        $q = $request->query('q');
        $categoryId = $request->query('category');
        $randomFeedback = Feedback::inRandomOrder()->first();

        $productsQuery = Product::with(['category', 'images'])->latest();

        if (!empty($q)) {
            $productsQuery->where('name', 'like', '%' . $q . '%');
        }

        if (!empty($categoryId)) {
            $productsQuery->where('category_id', $categoryId);
        }

        $products = $productsQuery->paginate(8)->withQueryString();

        // Kirim juga data kategori ke view untuk dropdown
        $categories = Category::all();

        return view('products.show', compact('products', 'q', 'categoryId', 'categories', 'randomFeedback'));
    }

    public function myProducts(Request $request)
    {
        $query = Product::with(['category', 'images'])->latest();

        if (Auth::user()->role !== 'admin') {
            // kalau bukan admin, hanya tampilkan produk milik user
            $query->where('user_id', Auth::id());
        }

        $products = $query->paginate(15)->withQueryString();

        $categories = Category::all();

        return view('products.my-products', compact('products', 'categories'));
    }

    public function show()
    {
        $products = Product::with(['category', 'images'])
            ->paginate(12)
            ->latest()
            ->get();

        return view('products.show', compact('products'));
    }

    // Tampilkan semua produk
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $query = Product::with(['category', 'images'])
            ->latest()
            ->when($q, fn($q2) => $q2->where('name', 'like', '%' . $q . '%'))
            ->when($categoryId, fn($q3) => $q3->where('category_id', $categoryId));

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Simpan produk baru

    public function store(Request $request)
    {
        $maxProducts = 4;
        $user = Auth::user();

        // Cek jumlah produk yang sudah dibuat user
        if ($user->products()->count() >= $maxProducts) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Anda hanya bisa menambahkan maksimal ' . $maxProducts . ' produk. Hapus produk yang sudah terjual!!');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:hakim_categories,id',
            'status' => 'required|in:tersedia,terjual',
            'phone' => 'required|string|max:20',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // sesuai name input
        ]);

        // Batasi jumlah gambar maksimal 3
        // if (count($request->file('image_path') ?? []) > 3) {
        //     return back()
        //         ->withErrors(['image_path' => 'Maksimal 3 gambar yang diperbolehkan.'])
        //         ->withInput();
        // }

        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'phone' => $request->phone,
        ]);

        // // Proses simpan gambar
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // Tambahkan di ProductController::store()
        // dd($request->file('image_path'));

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }
    // Form edit
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // dd($request->all());
        $this->authorize('update', $product);

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:tersedia,terjual',
            'phone' => 'required|string|max:20',
            'category_id' => 'required|exists:hakim_categories,id',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'phone' => $request->phone,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image_path')) {
            // Validasi hanya jika file dikirim
            $request->validate([
                'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Simpan gambar baru
            foreach ($request->file('image_path') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteImage(ProductImage $image)
    {
        $this->authorize('delete', $image->product); // hanya owner yang bisa hapus

        // Hapus file dari storage
        Storage::disk('public')->delete($image->image_path);

        // Hapus dari database
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.my')->with('success', 'Produk berhasil dihapus.');
    }
}
