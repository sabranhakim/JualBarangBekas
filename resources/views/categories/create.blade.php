<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="category_name" id="category_name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>

                    <div class="flex justify-start space-x-3">
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
                            Simpan
                        </button>
                        <a href="{{ route('categories.index') }}"
                           class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-4 py-2 rounded">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


