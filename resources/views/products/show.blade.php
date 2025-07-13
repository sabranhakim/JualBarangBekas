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

            <nav class="space-x-4 hidden md:flex font-bold">
                <a href="#categories" class="hover:text-indigo-600">Kategori</a>
                <a href="#products" class="hover:text-indigo-600">Produk</a>
                <a href="#feedback" class="hover:text-indigo-600">Feedback</a>
            </nav>

            <a href="{{ route('login') }}"
                class="text-sm bg-indigo-600 hover:bg-indigo-800 text-white px-4 py-2 rounded-md shadow-sm transition">
                Login untuk Jualan
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-4 flex flex-col-reverse md:flex-row items-center min-h-[400px] gap-6">

            <!-- Teks -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-4xl font-bold text-indigo-800 mb-4">
                    Temukan Barang Bekas Berkualitas
                </h1>
                <p class="text-gray-700 font-medium text-lg">
                    Beli barang second dengan harga terbaik dari penjual terpercaya.
                </p>
            </div>

            <!-- Gambar -->
            <div class="flex-1">
                <img src="{{ asset('images/hero2.png') }}" alt="Hero Image" class="w-full h-auto ">
            </div>

        </div>
    </section>

    <!-- Section Kategori -->
    <section id="categories" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-indigo-600 mb-6">Kategori Populer</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @forelse($categories as $category)
                    <div class="bg-indigo-50 text-center py-4 px-2 rounded shadow hover:bg-indigo-100 transition">
                        <h3 class="text-lg font-semibold text-indigo-700">{{ $category->category_name }}</h3>
                    </div>
                @empty
                    <p class="col-span-full text-gray-500 italic">Belum ada kategori tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Produk -->
    <main id="products" class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-xl font-semibold mb-6 text-indigo-600">Temukan Produk yang kamu inginkan</h2>

        <!-- Search Bar -->
        <form method="GET" action="" class="mb-8">
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}"
                    class="w-full sm:flex-1 px-4 py-2 border-2 border-indigo-600 rounded-lg shadow-sm focus:ring focus:ring-indigo-100 focus:border-indigo-600 transition">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition font-semibold">
                    Cari
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($products as $product)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden flex flex-col cursor-pointer border-2 border-indigo-100 hover:border-indigo-600 min-h-[420px]"
                    @click="selectedProduct = {{ $product->load('category', 'images')->toJson() }}; showDetail = true">

                    <div class="h-56 bg-gray-100">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 italic">
                                Tidak ada gambar
                            </div>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-base font-bold line-clamp-2 mb-1 text-indigo-600">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $product->category->category_name ?? '-' }}</p>
                        <p class="text-gray-700 text-sm mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}
                        </p>
                        <div class="mt-auto flex items-center justify-between">
                            <span class="text-indigo-700 font-bold text-lg">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span
                                class="text-xs px-2 py-1 rounded
                                    {{ $product->status == 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->status }}
                            </span>

                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-500 italic">Tidak ada produk tersedia saat ini.</p>
            @endforelse
        </div>
        {{-- Pagination --}}
        {{-- <div class="mt-6">
            {{ $products->links() }}
        </div> --}}
        <div class="" id="feedback">
            @if ($randomFeedback)
                <section class="max-w-7xl mx-auto px-4 py-8">
                    <div class="bg-indigo-50 text-center p-4 rounded-lg shadow">
                        <p class="text-gray-700 italic">
                            “{{ $randomFeedback->message }}”
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            - {{ $randomFeedback->name }}
                        </p>
                    </div>
                </section>
            @endif
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
                                <img :src="'/storage/' + img.image_path" class="w-full h-40 object-cover rounded shadow"
                                    alt="Gambar">
                            </template>
                        </template>
                        <p x-show="!selectedProduct?.images?.length" class="text-gray-500 italic col-span-full">Tidak
                            ada gambar.</p>
                    </div>
                </div>

                <!-- Detail -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-200">Deskripsi Produk</h3>

                    <p class="text-gray-700 mb-6 whitespace-pre-line" x-text="selectedProduct?.description"></p>

                    <div class="space-y-2">
                        <p>
                            <span class="font-semibold text-indigo-600">Kategori:</span>
                            <span x-text="selectedProduct?.category?.category_name ?? '-'"></span>
                        </p>
                        <p>
                            <span class="font-semibold text-indigo-600">Harga:</span>
                            Rp <span x-text="Number(selectedProduct?.price).toLocaleString()"></span>
                        </p>
                        <p>
                            <span class="font-semibold text-indigo-600">Status:</span>
                            <span x-text="selectedProduct?.status"></span>
                        </p>
                        <p>
                            <span class="font-semibold text-indigo-600">Kontak:</span>
                            <span x-text="selectedProduct?.phone ?? '-'"></span>
                        </p>
                    </div>

                    <div class="mt-8 text-right">
                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow transition duration-200"
                            @click="showDetail = false">
                            Tutup
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact" class="bg-indigo-600 text-white mt-12">
        <div
            class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <p>&copy; {{ date('Y') }} JualBarangBekas. All rights reserved.</p>
            <div class="space-x-4">
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
                <a href="#" class="hover:underline">Syarat & Ketentuan</a>
                <a href="#categories" class="hover:underline">Kategori</a>
                <a href="#products" class="hover:underline">Produk</a>
            </div>
        </div>
    </footer>

</body>

</html>
