@props(['product', 'isOwn' => false])

<div
    class="border bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden flex flex-col cursor-pointer border-2 border-indigo-100 hover:border-indigo-600 min-h-[420px]">
    {{-- Gambar Produk --}}
    <div class="w-full h-52 sm:h-64 bg-gray-100 overflow-hidden relative group">
        @if ($product->images->count())
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
        @else
            <div class="flex items-center justify-center h-full text-gray-400 italic">Tidak ada gambar</div>
        @endif

        {{-- Badge Milikku --}}
        @if ($isOwn)
            <div class="absolute top-12 left-2 bg-green-500 text-white font-bold text-xs px-2 py-1 rounded shadow">
                My product
            </div>
        @endif

        {{-- Lencana Harga di Sudut --}}
        <div class="absolute top-2 left-2 bg-white text-green-700 font-bold text-ml px-3 py-1 rounded-lg shadow">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>
        @auth
            <form method="POST" action="{{ route('favorites.toggle', $product) }}" class="absolute top-2 right-2 z-10">
                @csrf
                <button type="submit">
                    @if (auth()->user()->favorites->contains($product->id))
                        <svg class="w-6 h-6 text-red-500 hover:text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-gray-400 hover:text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd" />
                        </svg>
                    @endif
                </button>
            </form>
        @endauth

    </div>


    {{-- Informasi Produk --}}
    <div class="p-4 flex flex-col flex-1">
        <h3
            class="text-lg font-semibold text-gray-800 mb-1 truncate transition-all duration-300 group-hover:text-blue-700">
            {{ $product->name }}
        </h3>
        <p class="text-sm text-gray-500 mb-1">{{ $product->category->category_name ?? '-' }}</p>

        {{-- Status Badge --}}
        <span
            class="self-start text-xs font-semibold px-3 py-1 rounded-full mb-4 transition-all duration-300
            {{ $product->status === 'tersedia' ? 'bg-green-100 text-green-700 group-hover:bg-green-200' : 'bg-red-100 text-red-700 group-hover:bg-red-200' }}">
            {{ ucfirst($product->status) }}
        </span>

        {{-- Tombol Aksi --}}
        <div class="mt-auto flex flex-col sm:flex-row gap-2">
            <button
                x-on:click="selectedProduct = {{ $product->load('category', 'images')->toJson() }}; showDetail = true"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg text-center w-full sm:w-auto transform hover:scale-105 transition">
                Detail
            </button>

        </div>
    </div>
</div>
