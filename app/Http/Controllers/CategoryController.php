<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    // Tampilkan semua kategori
    public function index()
    {
        $this->authorize('viewAny', Category::class);

        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Form tambah kategori
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    // Simpan kategori
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $request->validate([
            'name' => 'required|string|max:100|unique:hakim_categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|string|max:100|unique:hakim_categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
