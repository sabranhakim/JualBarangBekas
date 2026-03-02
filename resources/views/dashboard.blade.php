<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-gradient-to-r from-slate-900 via-blue-900 to-cyan-800 text-white p-6 sm:p-8 shadow-xl">
                <h3 class="text-2xl font-extrabold">Selamat datang, {{ Auth::user()->name }}</h3>
                <p class="text-blue-100 mt-2 text-sm sm:text-base">Pantau performa produk, pengguna, dan feedback dari satu halaman.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Produk</p>
                    <p class="text-3xl font-black text-slate-900 mt-2">{{ $myProductCount }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pengguna</p>
                    <p class="text-3xl font-black text-blue-700 mt-2">{{ $userCount }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Kategori</p>
                    <p class="text-3xl font-black text-cyan-700 mt-2">{{ $categoryCount }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Produk Terjual</p>
                    <p class="text-3xl font-black text-emerald-700 mt-2">{{ $soldCount }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-slate-800">Tren Produk Terjual</h3>
                        <span class="text-xs text-slate-500">Tahun {{ now()->year }}</span>
                    </div>
                    <div class="h-72">
                        <canvas id="chart-sold"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Feedback Pilihan</h3>
                    @if ($randomFeedback)
                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <p class="text-sm text-slate-700 italic">"{{ $randomFeedback->message }}"</p>
                            <p class="text-xs text-slate-500 mt-3">{{ $randomFeedback->name ?? 'Anonim' }}</p>
                        </div>
                    @else
                        <p class="text-sm text-slate-500 italic">Belum ada feedback.</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Produk per Kategori</h3>
                    <div class="space-y-3">
                        @forelse ($productsPerCategory as $category)
                            <div class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3">
                                <span class="font-medium text-slate-700">{{ $category->category_name }}</span>
                                <span class="text-sm font-bold text-indigo-700">{{ $category->products_count }} produk</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic">Belum ada data kategori.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow border border-slate-100 p-5">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Produk Terbaru</h3>
                    <div class="space-y-3">
                        @forelse ($latestProducts as $product)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="font-semibold text-slate-800 truncate">{{ $product->name }}</p>
                                <p class="text-sm text-slate-500">{{ $product->category->category_name ?? '-' }}</p>
                                <p class="text-sm font-bold text-emerald-700 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic">Belum ada produk terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
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
                    label: 'Produk Terjual',
                    data: soldData,
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.16)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    tension: 0.35,
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
