<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Kategori Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-indigo-800">Daftar Kategori</h3>
                    <a href="{{ route('categories.create') }}"
                       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm text-sm transition">
                        + Tambah Kategori
                    </a>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-sm rounded-lg shadow">
                        <thead>
                            <tr class="bg-indigo-500 text-white">
                                <th class="px-4 py-2 text-left">Nama Kategori</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $c)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">
                                        <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-medium px-2 py-1 rounded">
                                            {{ $c->category_name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('categories.edit',$c) }}"
                                           class="inline-flex items-center px-2 py-1 text-xs bg-yellow-400 hover:bg-yellow-500 text-white rounded shadow-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.destroy',$c) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="inline-flex items-center px-2 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded shadow-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-4 text-center text-gray-500 italic">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
