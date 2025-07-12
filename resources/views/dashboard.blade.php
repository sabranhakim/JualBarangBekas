<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-10">

            {{-- Sambutan --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">Halo, {{ Auth::user()->name }} 👋</h3>
                <p class="text-gray-600 mt-2">Selamat datang di dashboard. Punya barang yang gak dipake?? Jual aja disini
                    biar cuan</p>
            </div>

            {{-- Ringkasan Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Total Produk --}}
                <div class="bg-white p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Total Produk</div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $myProductCount }}</div>
                </div>

                {{-- Total Pengguna --}}
                <div class="bg-white p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Total Pengguna</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $userCount }}</div>
                </div>

                {{-- Kategori --}}
                <div class="bg-white p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Kategori</div>
                    <div class="text-2xl font-bold text-pink-600">{{ $categoryCount }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 mt-4">
                {{-- Produk Terjual --}}
                <div class="bg-white p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Produk Terjual</div>
                    <div class="text-2xl font-bold text-green-600">{{ $soldCount }}</div>
                    <div class="relative h-20 mt-2">
                        <canvas id="chart-sold" class="mt-2"></canvas>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Jumlah Produk per Kategori</h3>

                @if ($productsPerCategory->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($productsPerCategory as $category)
                            <div class="border rounded-lg p-4 hover:shadow transition">
                                <div class="font-semibold text-gray-800">{{ $category->category_name }}</div>
                                <div class="text-sm text-gray-500">
                                    Produk: <span
                                        class="text-indigo-600 font-bold">{{ $category->products_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada kategori atau produk.</p>
                @endif
            </div>


            {{-- Produk Terbaru --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Produk Terbaru</h3>
                @if ($latestProducts->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($latestProducts as $product)
                            <div class="border rounded-lg p-4 hover:shadow transition">
                                <div class="font-semibold text-gray-800 truncate">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ $product->category->category_name ?? '-' }}</div>
                                <div class="text-green-600 font-bold mt-1">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada produk terbaru.</p>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="flex flex-col sm:flex-row justify-between gap-3">
                <a href="{{ route('products.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg shadow text-center">
                    Feedback
                </a>
            </div>

            {{-- Footer --}}
            <div class="text-center text-sm text-gray-400 mt-12">
                Terima kasih telah menggunakan aplikasi ini. ✨
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const soldLabels = {!! json_encode($soldPerMonth->pluck('month_name')) !!};
        const soldData = {!! json_encode($soldPerMonth->pluck('total')) !!};
    </script>
    <script>
        const ctx = document.getElementById('chart-sold').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: soldLabels,
                datasets: [{
                    label: 'Produk Terjual per Bulan',
                    data: soldData,
                    backgroundColor: 'rgba(34, 197, 94, 0.7)', // hijau
                    borderRadius: 4
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
</x-app-layout>
