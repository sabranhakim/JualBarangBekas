<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('My Products') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ showModal: false, selectedProduct: null, showProductModal(product) { this.selectedProduct = product; this.showModal = true; } }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Produk Anda</h3>

                <h4 class="text-md font-bold">Note</h4>
                <p class="mb-4 bg-red-200 rounded">** Jika produk sudah terjual lakukan update pada status barang menjadi terjual</p>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-500">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $product->name }}</td>
                                    <td class="px-4 py-2">{{ $product->category->category_name ?? '-' }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        @if ($product->status === 'tersedia')
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">{{ ucfirst($product->status) }}</span>
                                        @elseif ($product->status === 'terjual')
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">{{ ucfirst($product->status) }}</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">{{ ucfirst($product->status) }}</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 space-x-2 flex items-center">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-yellow-400 hover:bg-yellow-500 text-white rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5h2m-1-1v2m-4 4h8m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>

                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus produk ini?')"
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>

                                            </button>
                                        </form>

                                        <button @click="showProductModal({{ $product->toJson() }})"
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>

                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">Anda belum menambahkan produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Floating Tambah Produk Button --}}
        @if (Auth::user()->role !== 'admin')
            <a href="{{ route('products.create') }}"
                class="fixed bottom-10 right-6 sm:right-8 bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-full shadow-lg z-50 flex items-center space-x-2 transition transform hover:scale-105"
                title="Tambah Produk">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        @endif

        <!-- Modal Detail Produk -->
        <div x-show="showModal" x-transition @click.self="showModal = false"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4" x-cloak>
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl max-h-[90vh] overflow-y-auto">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Gambar -->
                    <div class="flex-1">
                        <h2 class="text-xl font-bold mb-2" x-text="selectedProduct?.name"></h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <template x-if="selectedProduct?.images?.length">
                                <template x-for="img in selectedProduct.images" :key="img.id">
                                    <img :src="'/storage/' + img.image_path" class="w-full h-40 object-cover rounded shadow" alt="Gambar">
                                </template>
                            </template>
                            <p x-show="!selectedProduct?.images?.length" class="text-gray-500 italic col-span-full">
                                Tidak ada gambar.
                            </p>
                        </div>
                    </div>

                    <!-- Detail -->
                    <div class="flex-1 bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-200">Deskripsi Produk</h3>

                        <p class="text-gray-700 mb-6 whitespace-pre-line" x-text="selectedProduct?.description"></p>

                        <div class="space-y-2">
                            <p><span class="font-semibold text-indigo-600">Kategori:</span> <span x-text="selectedProduct?.category?.category_name ?? '-'"></span></p>
                            <p><span class="font-semibold text-indigo-600">Harga:</span> Rp <span x-text="Number(selectedProduct?.price).toLocaleString()"></span></p>
                            <p><span class="font-semibold text-indigo-600">Status:</span> <span x-text="selectedProduct?.status"></span></p>
                            <p><span class="font-semibold text-indigo-600">Kontak:</span> <span x-text="selectedProduct?.phone ?? '-'"></span></p>
                        </div>

                        <div class="mt-8 text-right">
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow transition duration-200"
                                @click="showModal = false">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- end of x-data --}}
</x-app-layout>
