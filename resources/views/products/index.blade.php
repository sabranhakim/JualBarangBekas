<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Products Management') }}
        </h2>
    </x-slot>

    <div x-data="{ showDetail: false, selectedProduct: null, showFeedback: false }" @show-product.window="selectedProduct = $event.detail; showDetail = true" class="py-6" lang="id">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow border border-slate-100 p-4 sm:p-5">
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl">{{ session('success') }}</div>
                @endif

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Produk</h3>
                        <p class="text-sm text-slate-500">Kelola produk berdasarkan kategori dan pencarian.</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                    <div class="grid md:grid-cols-12 gap-3">
                        <div class="md:col-span-4">
                            <label for="category" class="text-sm font-medium text-slate-700">Kategori</label>
                            <select name="category" id="category"
                                class="mt-1 w-full px-4 py-2 rounded-xl border border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-6">
                            <label for="q" class="text-sm font-medium text-slate-700">Pencarian</label>
                            <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                                class="mt-1 w-full px-4 py-2 rounded-xl border border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                        </div>

                        <div class="md:col-span-2 flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-xl shadow-sm transition font-semibold">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" :is-own="$product->user_id === auth()->id()" />
                    @empty
                        <p class="col-span-full text-center text-slate-500 italic">Belum ada produk.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>

                <x-product-modal />
            </div>
        </div>

        @if (auth()->user()->role === 'user')
            <a href="{{ route('favorites.index') }}"
                class="fixed bottom-20 md:bottom-12 right-6 sm:bottom-28 sm:right-8 bg-pink-500 hover:bg-pink-600 text-white px-4 py-3 rounded-full shadow-lg flex items-center space-x-2 z-50 transition transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                </svg>
                <span class="hidden sm:inline text-sm font-semibold">Wishlist</span>
            </a>

            <button @click="showFeedback = true"
                class="fixed bottom-20 md:bottom-12 left-6 sm:bottom-28 sm:left-8 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-full shadow-lg flex items-center space-x-2 z-50 transition transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H5.414l-3.707 3.707A1 1 0 010 19V5z" />
                </svg>
                <span class="hidden sm:inline text-sm font-semibold">Feedback</span>
            </button>

            <div x-show="showFeedback" x-transition @click.self="showFeedback = false"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4" x-cloak>
                <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-indigo-700">Kirim Feedback</h3>
                        <button @click="showFeedback = false" class="text-gray-500 hover:text-gray-700">x</button>
                    </div>

                    <form method="POST" action="{{ route('feedback.store') }}" class="space-y-4">
                        @csrf
                        @guest
                            <input type="text" name="name" placeholder="Nama" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm" />
                            <input type="email" name="email" placeholder="Email" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm" />
                        @endguest
                        <textarea name="message" placeholder="Pesan / Saran" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm"></textarea>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showFeedback = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded text-sm">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm shadow">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
