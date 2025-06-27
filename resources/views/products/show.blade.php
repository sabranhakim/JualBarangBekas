<!DOCTYPE html>
<html lang="id" x-data="{ showDetail: false, selectedProduct: null }" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <title>JualBarangBekas - Semua Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-1">
                <span class="text-xl sm:text-2xl font-extrabold text-indigo-600">Jual</span>
                <span class="text-xl sm:text-2xl font-semibold text-gray-800">BarangBekas</span>
            </a>

            <a href="{{ route('login') }}"
                class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-sm transition">
                Login untuk Jualan
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-green-100 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl font-bold text-green-800 mb-2">Temukan Barang Bekas Berkualitas</h1>
            <p class="text-gray-700 text-sm">Beli barang second dengan harga terbaik dari penjual terpercaya</p>
        </div>
    </section>

    <!-- Produk -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-xl font-semibold mb-6">Produk Terbaru</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden flex flex-col cursor-pointer"
                    @click="selectedProduct = {{ $product->load('category', 'images')->toJson() }}; showDetail = true">

                    <div class="h-40 bg-gray-100">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 italic">
                                Tidak ada gambar
                            </div>
                        @endif
                    </div>

                    <div class="p-3 flex flex-col flex-1">
                        <h3 class="text-sm font-semibold line-clamp-2 mb-1">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $product->category->category_name ?? '-' }}</p>
                        <p class="text-green-700 font-bold text-sm mt-auto">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-500 italic">Tidak ada produk tersedia saat ini.</p>
            @endforelse
        </div>
    </main>

    <!-- Modal Detail Produk -->
    <div x-show="showDetail" x-transition @click.self="showDetail = false"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl max-h-[90vh] overflow-y-auto">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Gambar -->
                <div class="flex-1">
                    <h2 class="text-xl font-bold mb-2" x-text="selectedProduct?.name"></h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-if="selectedProduct?.images?.length">
                            <template x-for="img in selectedProduct.images" :key="img.id">
                                <img :src="'/storage/' + img.image_path"
                                    class="w-full h-40 object-cover rounded shadow" alt="Gambar">
                            </template>
                        </template>
                        <p x-show="!selectedProduct?.images?.length"
                            class="text-gray-500 italic col-span-full">Tidak ada gambar.</p>
                    </div>
                </div>

                <!-- Detail -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Deskripsi Produk</h3>
                    <p class="text-gray-700 mb-4 whitespace-pre-line" x-text="selectedProduct?.description"></p>

                    <p><span class="font-semibold">Kategori:</span> <span
                            x-text="selectedProduct?.category?.category_name ?? '-'"></span></p>
                    <p><span class="font-semibold">Harga:</span> Rp <span
                            x-text="Number(selectedProduct?.price).toLocaleString()"></span></p>
                    <p><span class="font-semibold">Status:</span> <span
                            x-text="selectedProduct?.status"></span></p>
                    <p><span class="font-semibold">Kontak:</span> <span
                            x-text="selectedProduct?.phone ?? '-'"></span></p>

                    <div class="mt-6 text-right">
                        <button class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded"
                            @click="showDetail = false">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} JualBarangBekas. All rights reserved.
        </div>
    </footer>

</body>

</html>
