<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kategori Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Daftar Kategori</h3>
                    <a href="{{ route('categories.create') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        + Tambah Kategori
                    </a>
                </div>

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Nama Kategori</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $c)
                            <tr>
                                <td class="border px-4 py-2">{{ $c->category_name }}</td>
                                <td class="border px-4 py-2 space-x-2">
                                    <a href="{{ route('categories.edit',$c) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy',$c) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Hapus kategori?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center border px-4 py-2">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
