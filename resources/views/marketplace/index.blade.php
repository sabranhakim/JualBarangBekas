<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-4">
                <form method="GET" action="{{ route('marketplace.index') }}" class="grid md:grid-cols-12 gap-3">
                    <div class="md:col-span-5">
                        <label for="q" class="text-sm font-medium text-gray-700">Cari produk</label>
                        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..."
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                    </div>
                    <div class="md:col-span-4">
                        <label for="category" class="text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category" name="category"
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (string) request('category') === (string) $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3 flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                        <div class="h-48 bg-gray-100 overflow-hidden">
                            @if ($product->images->count())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="h-full flex items-center justify-center text-sm text-gray-400 italic">Tidak ada gambar</div>
                            @endif
                        </div>

                        <div class="p-4 space-y-2">
                            <p class="text-xs text-indigo-600 font-semibold">{{ $product->category->category_name ?? '-' }}</p>
                            <h3 class="font-bold text-gray-800 line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($product->description, 70) }}</p>
                            <p class="text-xs text-gray-500">Penjual: {{ $product->user->name ?? '-' }}</p>
                            <p class="text-lg font-extrabold text-indigo-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            <a href="{{ route('marketplace.checkout', $product) }}"
                                class="inline-flex w-full justify-center rounded-lg px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition">
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl p-8 text-center text-gray-500 italic">
                        Produk yang bisa dibeli belum tersedia.
                    </div>
                @endforelse
            </div>

            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
