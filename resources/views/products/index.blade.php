<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div x-data="{ showDetail: false, selectedProduct: null }" @show-product.window="selectedProduct = $event.detail; showDetail = true" class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">


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

                <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center gap-3">

                        <!-- Filter Kategori -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                            <label for="category" class="text-gray-700 font-medium text-sm">Filter Kategori:</label>

                            <select name="category" id="category"
                                class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Bar -->
                        <div class="flex-1">
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="Cari produk..."
                                class="w-full px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-md shadow-sm transition">
                            Cari
                        </button>
                    </div>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full text-center text-gray-500 italic">Belum ada produk dari pengguna lain.
                        </p>
                    @endforelse
                </div>
                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $products->links() }}
                </div>

                <x-product-modal />
            </div>
        </div>

        {{-- Floating Wishlist Button --}}
        <a href="{{ route('favorites.index') }}"
            class="fixed bottom-20 md:bottom-12 right-6 sm:bottom-28 sm:right-8 bg-pink-500 hover:bg-pink-600 text-white px-4 py-3 rounded-full shadow-lg flex items-center space-x-2 z-50 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
            </svg>
            <span class="hidden sm:inline text-sm font-semibold">Wishlist</span>
        </a>

    </div>
</x-app-layout>
