<!DOCTYPE html>
<html lang="id" x-data="{ showDetail: false, selectedProduct: null }" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <title>JualBarangBekas - Semua Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @layer utilities {
            .animate-fade-in {
                animation: fadeIn 1s ease-out forwards;
            }

            .animate-fade-in-up {
                animation: fadeInUp 1s ease-out forwards;
            }

            @keyframes fadeIn {
                0% {
                    opacity: 0;
                }

                100% {
                    opacity: 1;
                }
            }

            @keyframes fadeInUp {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-1">
                <span class="text-xl sm:text-2xl font-extrabold text-indigo-600">Jual</span>
                <span class="text-xl sm:text-2xl font-bold text-gray-800">BarangBekas</span>
            </a>
            <nav class="space-x-4 hidden md:flex font-bold">
                <a href="#categories" class="hover:text-indigo-600">Categories</a>
                <a href="#products" class="hover:text-indigo-600">Products</a>
                <a href="#feedback" class="hover:text-indigo-600">Feedback</a>
            </nav>
            <a href="{{ route('login') }}"
                class="text-sm font-bold bg-indigo-600 hover:bg-indigo-800 text-white px-4 py-2 rounded-md shadow-sm transition">Login
                untuk Jualan</a>
        </div>
    </header>

    <section class="relative bg-gradient-to-r from-indigo-700 via-indigo-600 to-indigo-500 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20 sm:py-32 flex flex-col md:flex-row items-center gap-8">

            <div class="flex-1 text-center md:text-left animate-fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 leading-tight tracking-tight">Temukan Barang <span
                        class="text-yellow-300">Bekas Berkualitas</span></h1>
                <p class="text-lg sm:text-xl text-indigo-100 font-medium mb-6">Beli barang second terbaik, hemat & ramah
                    lingkungan 🌱</p>
                {{-- <div class="flex justify-center md:justify-start gap-4">
                    <a href="#products"
                        class="px-6 py-3 bg-yellow-300 text-indigo-800 font-semibold rounded shadow hover:bg-yellow-400 transition">Lihat
                        Produk</a>
                    <a href="#feedback"
                        class="px-6 py-3 border border-white text-white font-semibold rounded hover:bg-white hover:text-indigo-700 transition">Beri
                        Feedback</a>
                </div> --}}
            </div>

            <div class="flex-1 flex justify-center md:justify-end animate-fade-in">
                <img src="{{ asset('images/hero2.png') }}" alt="Barang Bekas Berkualitas"
                    class="w-full max-w-sm md:max-w-md lg:max-w-lg rounded-xl shadow-xl ring-4 ring-indigo-300">
            </div>

        </div>
        <div class="absolute inset-0">
            <div
                class="absolute -top-24 -left-20 w-96 h-96 bg-indigo-300 opacity-20 rounded-full blur-3xl animate-pulse">
            </div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-900 opacity-10 rounded-full blur-2xl"></div>
        </div>
    </section>

    <section id="categories" class="py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl text-center font-bold text-indigo-600 mb-6">Categories</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @forelse($categories as $category)
                    <div
                        class="bg-indigo-50 text-center py-6 px-4 rounded shadow hover:bg-indigo-100 transition transform hover:-translate-y-1 hover:shadow-md group cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-indigo-100 opacity-0 group-hover:opacity-50 transition"></div>
                        <h3 class="text-lg font-semibold text-indigo-700 relative z-10">{{ $category->category_name }}
                        </h3>
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-300 scale-x-0 group-hover:scale-x-100 transition-transform origin-left">
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-gray-500 italic">Belum ada kategori tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <main id="products" class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl text-center font-bold mb-6 text-indigo-600">Products</h2>
        <form method="GET" action="" class="mb-8">
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}"
                    class="w-full sm:flex-1 px-4 py-2 border-2 border-indigo-600 rounded-lg shadow-sm focus:ring focus:ring-indigo-100 focus:border-indigo-600 transition">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition font-semibold">Cari</button>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition transform hover:-translate-y-1 hover:ring-2 hover:ring-indigo-300 flex flex-col cursor-pointer min-h-[420px]"
                    @click="selectedProduct = {{ $product->load('category', 'images')->toJson() }}; showDetail = true">

                    <div class="h-56 bg-gray-100 relative overflow-hidden">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transform hover:scale-105 transition">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 italic">Tidak ada
                                gambar</div>
                        @endif
                        <span
                            class="absolute top-2 right-2 bg-white text-xs font-semibold px-2 py-1 rounded shadow {{ $product->status == 'tersedia' ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100' }}">{{ $product->status }}</span>
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-base font-bold line-clamp-2 mb-1 text-indigo-700">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $product->category->category_name ?? '-' }}</p>
                        <p class="text-gray-700 text-sm mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}
                        </p>
                        <div class="mt-auto flex items-center justify-between">
                            <span class="text-indigo-700 font-bold text-lg">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-500 italic">Tidak ada produk tersedia saat ini.</p>
            @endforelse
        </div>
    </main>

    <div class="max-w-4xl mx-auto px-4 mt-16 bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-600 rounded-lg shadow-lg text-white relative overflow-hidden"
        id="feedback">
        <div class="absolute right-0 top-0 opacity-10">
            <svg width="200" height="200" fill="none">
                <circle cx="100" cy="100" r="100" fill="white" />
            </svg>
        </div>
        <div class="p-8 space-y-6">
            <h2 class="text-3xl font-extrabold text-center">Kirimkan Feedbackmu</h2>
            <form method="POST" action="{{ route('feedback.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input name="name" required
                        class="w-full rounded-md px-3 py-2 text-black shadow focus:ring-indigo-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input name="email" required
                        class="w-full rounded-md px-3 py-2 text-black shadow focus:ring-indigo-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Pesan</label>
                    <textarea name="message" rows="4" required
                        class="w-full rounded-md px-3 py-2 text-black shadow focus:ring-indigo-300"></textarea>
                </div>
                <div class="text-right">
                    <button
                        class="bg-yellow-300 hover:bg-yellow-400 text-indigo-800 px-6 py-2 rounded font-bold shadow transition">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-indigo-900 text-indigo-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-yellow-300">JualBarangBekas</span>. All rights
                reserved.</p>
            <div class="space-x-4 text-sm">
                <a href="#" class="hover:text-yellow-300">Kebijakan Privasi</a>
                <a href="#" class="hover:text-yellow-300">Syarat & Ketentuan</a>
                <a href="#categories" class="hover:text-yellow-300">Kategori</a>
                <a href="#products" class="hover:text-yellow-300">Produk</a>
            </div>
        </div>
    </footer>

</body>

</html>
