<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function showAll()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->get();

        return view('products.show', compact('products'));
    }

    public function show()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->get();

        return view('products.show', compact('products'));
    }

    // Tampilkan semua produk
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->get();
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
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
