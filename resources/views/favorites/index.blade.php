<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-800 leading-tight">
            Wishlist Saya
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">
            {{-- Tombol Kembali --}}
            <div>
                <a href="{{ url()->previous() }}"
                    class="inline-block text-sm text-indigo-600 hover:underline">&larr; Kembali</a>
            </div>

            {{-- Daftar Produk Favorite --}}
            @if($favorites->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach ($favorites as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                            <a href="{{ route('products.index', $product) }}" class="flex-1">
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
                                <div class="p-3">
                                    <h3 class="text-sm font-semibold truncate">{{ $product->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $product->category->category_name ?? '-' }}</p>
                                    <p class="text-green-700 font-bold text-sm mt-1">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-6 rounded shadow text-center text-gray-500 italic">
                    Belum ada produk yang kamu favoritkan.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
