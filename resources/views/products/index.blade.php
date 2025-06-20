<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Produk') }}
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
                    <a href="{{ route('products.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        + Tambah Produk
                    </a>
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
    </div>
</x-app-layout>
