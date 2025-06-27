<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div x-data="{ showDetail: false, selectedProduct: null }" @show-product.window="selectedProduct = $event.detail; showDetail = true" class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <form method="GET" action="{{ route('products.index') }}" class="mb-6 w-full md:w-1/2">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <label for="category" class="text-gray-700 font-medium text-sm">Filter Kategori:</label>

                        <div class="w-full sm:w-auto">
                            <select name="category" id="category" onchange="this.form.submit()"
                                class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200 focus:border-blue-400 text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Produk Saya</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
                    @forelse ($products->where('user_id', auth()->id()) as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full text-center text-gray-500 italic">Anda belum menambahkan produk.</p>
                    @endforelse
                </div>

                <h3 class="text-lg font-bold mb-4">Produk Lainnya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($products->where('user_id', '!=', auth()->id()) as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full text-center text-gray-500 italic">Belum ada produk dari pengguna lain.
                        </p>
                    @endforelse
                </div>

                <x-product-modal />
            </div>
        </div>
        {{-- Floating Wishlist Button --}}
        <a href="{{ route('favorites.index') }}"
            class="fixed bottom-25 md:bottom-32
 right-6 sm:bottom-28 sm:right-8 bg-pink-500 hover:bg-pink-600 text-white px-4 py-3 rounded-full shadow-lg flex items-center space-x-2 z-50 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
            </svg>
            <span class="hidden sm:inline text-sm font-semibold">Wishlist</span>
        </a>

        {{-- Floating Tambah Produk Button --}}
        <a href="{{ route('products.create') }}"
            class="fixed bottom-10 right-6 sm:right-8 bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg z-50 flex items-center space-x-2 transition transform hover:scale-105"
            title="Tambah Produk">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>


    </div>
</x-app-layout>
