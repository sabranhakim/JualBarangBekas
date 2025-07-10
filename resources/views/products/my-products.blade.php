<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('My Products') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Produk Anda</h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-600">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    No</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Kategori</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Aksi</th>
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
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        @elseif ($product->status === 'terjual')
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="px-2 py-1 text-xs bg-yellow-400 hover:bg-yellow-500 text-white rounded">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus produk ini?')"
                                                class="px-2 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">
                                        Anda belum menambahkan produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

</x-app-layout>
