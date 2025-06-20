@props(['product'])

<div class="border rounded-lg shadow hover:shadow-lg transition bg-white p-4 flex flex-col">
    <div class="w-full h-48 bg-gray-100 rounded mb-3 overflow-hidden flex justify-center items-center">
        @if ($product->images->count())
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                 alt="{{ $product->name }}" class="object-cover h-full w-full">
        @else
            <span class="text-gray-400 italic">Tidak ada gambar</span>
        @endif
    </div>

    <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
    <p class="text-sm text-gray-500 mb-1">{{ $product->category->category_name ?? '-' }}</p>
    <p class="text-md font-semibold text-green-700 mb-2">
        Rp {{ number_format($product->price, 0, ',', '.') }}
    </p>
    <span class="inline-block text-xs px-2 py-1 rounded-full mb-3 
        {{ $product->status === 'tersedia' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
        {{ ucfirst($product->status) }}
    </span>

    <div class="mt-auto flex flex-wrap gap-2">
        <button 
    x-on:click="selectedProduct = {{ $product->load('category', 'images')->toJson() }}; showDetail = true"
    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
    Detail
</button>


        @can('update', $product)
            <a href="{{ route('products.edit', $product) }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                Edit
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST"
                  onsubmit="return confirm('Hapus produk?')" class="inline">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                    Hapus
                </button>
            </form>
        @endcan
    </div>
</div>
