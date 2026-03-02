<!DOCTYPE html>
<html lang="id" x-data="landingPage()" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>JualBarangBekas - Temukan Produk Pilihan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --brand-1: #0f172a;
            --brand-2: #1d4ed8;
            --brand-3: #06b6d4;
            --brand-4: #f59e0b;
        }

        body {
            background: radial-gradient(circle at 15% 20%, rgba(59, 130, 246, .2), transparent 40%),
                radial-gradient(circle at 85% 15%, rgba(6, 182, 212, .18), transparent 42%),
                radial-gradient(circle at 70% 80%, rgba(245, 158, 11, .14), transparent 38%),
                #f8fafc;
        }

        .glass {
            background: rgba(255, 255, 255, .72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .65);
        }

        .hero-grid {
            background-image:
                linear-gradient(rgba(148, 163, 184, .14) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, .14) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .blob {
            animation: blobFloat 9s ease-in-out infinite;
        }

        .blob.delay-1 {
            animation-delay: 1.5s;
        }

        .blob.delay-2 {
            animation-delay: 3s;
        }

        @keyframes blobFloat {
            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-14px) scale(1.03);
            }
        }

        .fade-up {
            animation: fadeUp .7s ease-out forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen">
    <header class="sticky top-0 z-50 border-b border-white/30 glass">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('products.public.index') }}" class="font-black text-lg sm:text-xl tracking-tight">
                <span class="text-slate-900">Jual</span><span class="text-blue-600">Barang</span><span
                    class="text-cyan-500">Bekas</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600">
                <a href="#kategori" class="hover:text-blue-600 transition">Kategori</a>
                <a href="#produk" class="hover:text-blue-600 transition">Produk</a>
                <a href="#feedback" class="hover:text-blue-600 transition">Feedback</a>
            </nav>

            <a href="{{ route('login') }}"
                class="rounded-full bg-slate-900 text-white text-sm font-semibold px-4 py-2 hover:bg-blue-700 transition shadow">
                Login
            </a>
        </div>
    </header>

    <section class="relative overflow-hidden">
        <div class="absolute -top-16 -left-16 w-64 h-64 rounded-full bg-blue-400/25 blur-3xl blob"></div>
        <div class="absolute top-10 right-0 w-72 h-72 rounded-full bg-cyan-300/25 blur-3xl blob delay-1"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 rounded-full bg-amber-300/20 blur-3xl blob delay-2"></div>

        <div class="hero-grid">
            <div class="max-w-7xl mx-auto px-4 py-16 sm:py-20 lg:py-24 relative z-10">
                <div class="grid lg:grid-cols-2 gap-10 items-center">
                    <div class="fade-up">
                        <p class="inline-flex items-center rounded-full bg-white/80 px-3 py-1 text-xs font-bold text-blue-700 mb-5">
                            Marketplace Barang Bekas Terpercaya
                        </p>
                        <h1 class="text-4xl sm:text-5xl font-black leading-tight text-slate-900">
                            Beli Barang Bagus,
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Harga Lebih Masuk Akal</span>
                        </h1>
                        <p class="mt-5 text-slate-600 text-base sm:text-lg max-w-xl">
                            Temukan produk second berkualitas dari pengguna terverifikasi. Jelajahi kategori favoritmu dan cek detail produk dengan cepat.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="#produk"
                                class="rounded-full bg-blue-600 text-white font-semibold px-6 py-3 hover:bg-blue-700 transition shadow-lg shadow-blue-600/25">
                                Jelajahi Produk
                            </a>
                            <a href="#feedback"
                                class="rounded-full bg-white text-slate-700 font-semibold px-6 py-3 border border-slate-200 hover:border-blue-300 hover:text-blue-700 transition">
                                Beri Feedback
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-3 gap-3 max-w-md">
                            <div class="glass rounded-xl p-3 text-center">
                                <p class="text-xl font-black text-blue-700">{{ $products->count() }}+</p>
                                <p class="text-xs text-slate-600">Produk tampil</p>
                            </div>
                            <div class="glass rounded-xl p-3 text-center">
                                <p class="text-xl font-black text-cyan-600">{{ $categories->count() }}</p>
                                <p class="text-xs text-slate-600">Kategori</p>
                            </div>
                            <div class="glass rounded-xl p-3 text-center">
                                <p class="text-xl font-black text-amber-600">24/7</p>
                                <p class="text-xs text-slate-600">Akses online</p>
                            </div>
                        </div>
                    </div>

                    <div class="fade-up" style="animation-delay:.15s;">
                        <div class="glass rounded-3xl p-4 shadow-2xl shadow-blue-900/10">
                            <img src="{{ asset('images/hero2.png') }}" alt="Ilustrasi jual beli barang bekas"
                                class="w-full rounded-2xl object-cover max-h-[430px]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kategori" class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex items-end justify-between gap-4 mb-5">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Kategori Populer</h2>
                <p class="text-slate-500 text-sm mt-1">Pilih kategori untuk mempercepat pencarian produk.</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('products.public.index') }}#produk"
                class="px-4 py-2 rounded-full text-sm font-semibold transition {{ empty($categoryId) ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-700' }}">
                Semua
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('products.public.index', ['category' => $category->id, 'q' => $q]) }}#produk"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition {{ (string) $categoryId === (string) $category->id ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:border-blue-300 hover:text-blue-700' }}">
                    {{ $category->category_name }}
                </a>
            @endforeach
        </div>
    </section>

    <main id="produk" class="max-w-7xl mx-auto px-4 pb-10">
        <div class="glass rounded-2xl p-4 sm:p-5 mb-7 shadow-sm">
            <form method="GET" action="{{ route('products.public.index') }}" class="grid md:grid-cols-12 gap-3">
                <div class="md:col-span-5">
                    <label for="q" class="text-xs font-semibold text-slate-500">Cari produk</label>
                    <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Contoh: laptop, helm, buku"
                        class="mt-1 w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                </div>
                <div class="md:col-span-4">
                    <label for="category" class="text-xs font-semibold text-slate-500">Kategori</label>
                    <select id="category" name="category"
                        class="mt-1 w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) request('category') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3 flex items-end">
                    <button type="submit"
                        class="w-full rounded-xl bg-slate-900 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 transition">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse ($products as $product)
                <article
                    class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-100/70 transition overflow-hidden cursor-pointer"
                    @click='openProduct(@json($product->load("category", "images")))'>
                    <div class="h-52 bg-slate-100 overflow-hidden relative">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm italic">Tidak ada gambar</div>
                        @endif

                        <div class="absolute top-3 left-3 text-xs font-bold px-2.5 py-1 rounded-full {{ $product->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ ucfirst($product->status) }}
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="text-xs font-semibold text-blue-700 mb-1">{{ $product->category->category_name ?? 'Tanpa kategori' }}</p>
                        <h3 class="text-base font-bold text-slate-900 line-clamp-2 min-h-[48px]">{{ $product->name }}</h3>
                        <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ Str::limit($product->description, 78) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-black text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-slate-400">Lihat detail</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
                    Produk belum tersedia untuk filter yang dipilih.
                </div>
            @endforelse
        </div>

        <div class="mt-7">
            {{ $products->links() }}
        </div>
    </main>

    <section id="feedback" class="max-w-4xl mx-auto px-4 pb-16 mt-4">
        <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-cyan-800 rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-6 sm:p-8 md:p-10">
                <h2 class="text-2xl sm:text-3xl font-black text-white">Punya Saran Untuk Kami?</h2>
                <p class="text-blue-100 mt-2 text-sm sm:text-base">Masukan kamu bantu kami bikin pengalaman jual beli jadi lebih baik.</p>

                <form method="POST" action="{{ route('feedback.store') }}" class="mt-6 space-y-4">
                    @csrf
                    @guest
                        <div class="grid sm:grid-cols-2 gap-4">
                            <input name="name" required placeholder="Nama"
                                class="w-full rounded-xl px-4 py-2.5 bg-white/95 border border-white/60 text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-cyan-200">
                            <input name="email" type="email" required placeholder="Email"
                                class="w-full rounded-xl px-4 py-2.5 bg-white/95 border border-white/60 text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-cyan-200">
                        </div>
                    @endguest
                    <textarea name="message" rows="4" required maxlength="100" placeholder="Tulis feedback kamu..."
                        class="w-full rounded-xl px-4 py-3 bg-white/95 border border-white/60 text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-cyan-200"></textarea>

                    <div class="text-right">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold px-6 py-2.5 transition">
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div x-show="showDetail" x-cloak x-transition class="fixed inset-0 z-[60] bg-slate-900/60 backdrop-blur-sm p-4"
        @click.self="showDetail = false">
        <div class="max-w-5xl mx-auto mt-8 bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-0">
                <div class="bg-slate-100 p-4 sm:p-5">
                    <template x-if="selectedProduct?.images?.length">
                        <div>
                            <div class="h-[320px] sm:h-[380px] bg-white rounded-xl overflow-hidden flex items-center justify-center">
                                <img :src="'/storage/' + selectedProduct.images[slideIndex].image_path" alt="Produk"
                                    class="max-h-full object-contain">
                            </div>
                            <div class="mt-3 flex gap-2 items-center justify-center">
                                <button @click="slideIndex = (slideIndex - 1 + selectedProduct.images.length) % selectedProduct.images.length"
                                    class="w-9 h-9 rounded-full bg-slate-800 text-white font-bold">&lsaquo;</button>
                                <template x-for="(img, idx) in selectedProduct.images" :key="idx">
                                    <button @click="slideIndex = idx" class="w-2.5 h-2.5 rounded-full"
                                        :class="slideIndex === idx ? 'bg-blue-600' : 'bg-slate-300'"></button>
                                </template>
                                <button @click="slideIndex = (slideIndex + 1) % selectedProduct.images.length"
                                    class="w-9 h-9 rounded-full bg-slate-800 text-white font-bold">&rsaquo;</button>
                            </div>
                        </div>
                    </template>
                    <template x-if="!selectedProduct?.images?.length">
                        <div class="h-[320px] sm:h-[380px] rounded-xl bg-white flex items-center justify-center text-slate-400 italic">
                            Tidak ada gambar
                        </div>
                    </template>
                </div>

                <div class="p-6 sm:p-7">
                    <div class="flex justify-between items-start gap-4">
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900" x-text="selectedProduct?.name"></h3>
                        <button @click="showDetail = false" class="text-slate-400 hover:text-slate-700 text-xl">&times;</button>
                    </div>

                    <p class="mt-2 inline-flex text-xs font-semibold px-2.5 py-1 rounded-full"
                        :class="selectedProduct?.status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'"
                        x-text="selectedProduct?.status"></p>

                    <p class="mt-5 text-sm text-slate-600 leading-relaxed" x-text="selectedProduct?.description"></p>

                    <div class="mt-6 space-y-2 text-sm">
                        <p><span class="font-semibold text-slate-500">Kategori:</span> <span class="font-bold text-slate-800"
                                x-text="selectedProduct?.category?.category_name ?? '-' "></span></p>
                        <p><span class="font-semibold text-slate-500">Harga:</span> <span class="font-black text-blue-700"
                                x-text="'Rp ' + Number(selectedProduct?.price || 0).toLocaleString('id-ID')"></span></p>
                        <p><span class="font-semibold text-slate-500">Kontak:</span> <span class="font-bold text-slate-800"
                                x-text="selectedProduct?.phone ?? '-' "></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="border-t border-slate-200 bg-white/70 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col sm:flex-row justify-between gap-2 text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} JualBarangBekas</p>
            <p>Platform jual beli barang bekas modern untuk semua kalangan.</p>
        </div>
    </footer>

    <script>
        function landingPage() {
            return {
                showDetail: false,
                selectedProduct: null,
                slideIndex: 0,
                openProduct(product) {
                    this.selectedProduct = product;
                    this.slideIndex = 0;
                    this.showDetail = true;
                }
            };
        }
    </script>
</body>

</html>
