<x-app-layout>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard - JualBarangBekas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            @keyframes pulse-border {
                0% {
                    box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
                }
            }

            .pulse-border {
                animation: pulse-border 2s infinite;
            }
        </style>
    </head>

    <body class="bg-gradient-to-br from-indigo-50 to-white min-h-screen text-gray-800">
        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-10">

            <div class="bg-white/70 backdrop-blur shadow-lg rounded-xl p-6 border-t-4 border-indigo-500">
                <h3 class="text-2xl font-bold text-indigo-700">Halo, {{ Auth::user()->name }} 👋</h3>
                <p class="text-gray-600 mt-2">Selamat datang di dashboard. Punya barang yang gak dipake? <span
                        class="font-semibold text-indigo-500">Jual aja disini biar cuan 💸</span></p>
            </div>

            <!-- Baris pertama: 3 statistik utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-gradient-to-r from-indigo-100 to-indigo-50 rounded-xl p-6 shadow text-center hover:-translate-y-1 transition pulse-border flex flex-col justify-center">
                    <div class="text-sm text-gray-500">Total Produk</div>
                    <div class="text-3xl font-extrabold text-indigo-700">{{ $myProductCount }}</div>
                </div>

                <div
                    class="bg-gradient-to-r from-yellow-100 to-yellow-50 rounded-xl p-6 shadow text-center hover:-translate-y-1 transition pulse-border flex flex-col justify-center">
                    <div class="text-sm text-gray-500">Total Pengguna</div>
                    <div class="text-3xl font-extrabold text-yellow-600">{{ $userCount }}</div>
                </div>

                <div
                    class="bg-gradient-to-r from-pink-100 to-pink-50 rounded-xl p-6 shadow text-center hover:-translate-y-1 transition pulse-border flex flex-col justify-center">
                    <div class="text-sm text-gray-500">Kategori</div>
                    <div class="text-3xl font-extrabold text-pink-600">{{ $categoryCount }}</div>
                </div>
            </div>

            <!-- Baris kedua: Produk Terjual -->
            <div
                class="bg-gradient-to-r from-green-100 to-green-50 rounded-xl p-6 shadow text-center hover:-translate-y-1 transition flex flex-col justify-between h-64">
                <div>
                    <div class="text-sm text-gray-500">Produk Terjual</div>
                    <div class="text-3xl font-extrabold text-green-600">{{ $soldCount }}</div>
                </div>
                <div class="flex-grow mt-4">
                    <canvas id="chart-sold" class="h-full"></canvas>
                </div>
            </div>


            <!-- Produk per Kategori -->
            <div class="bg-white/70 backdrop-blur shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-bold text-indigo-700 mb-4">Jumlah Produk per Kategori</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse ($productsPerCategory as $category)
                        <div
                            class="bg-indigo-50 hover:bg-indigo-100 p-4 rounded-lg shadow transition text-center flex flex-col justify-center min-h-[100px]">
                            <div class="font-semibold text-indigo-700">{{ $category->category_name }}</div>
                            <div class="text-sm text-gray-500">Produk: <span
                                    class="text-indigo-600 font-bold">{{ $category->products_count }}</span></div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Belum ada kategori atau produk.</p>
                    @endforelse
                </div>
            </div>

            <!-- Produk Terbaru -->
            <div class="bg-white/70 backdrop-blur shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-bold text-indigo-700 mb-4">Produk Terbaru</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse ($latestProducts as $product)
                        <div
                            class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow border border-gray-100 transition flex flex-col justify-between min-h-[120px]">
                            <div class="font-bold text-indigo-700 truncate">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->category->category_name ?? '-' }}</div>
                            <div class="text-green-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Belum ada produk terbaru.</p>
                    @endforelse
                </div>
            </div>

            @if ($randomFeedback)
                <div class="bg-indigo-100 text-center p-4 rounded-lg shadow mt-8 animate-pulse">
                    <p class="text-gray-700 italic">“{{ $randomFeedback->message }}”</p>
                    <p class="text-sm text-gray-500 mt-2">- {{ $randomFeedback->name }}</p>
                </div>
            @endif

            <div class="text-center text-sm text-gray-400 mt-12">Terima kasih telah menggunakan aplikasi ini. ✨</div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const soldLabels = {!! json_encode($soldPerMonth->pluck('month_name')) !!};
            const soldData = {!! json_encode($soldPerMonth->pluck('total')) !!};
            const ctx = document.getElementById('chart-sold').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: soldLabels,
                    datasets: [{
                        label: 'Produk Terjual per Bulan',
                        data: soldData,
                        fill: true,
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    </body>

    </html>



</x-app-layout>
