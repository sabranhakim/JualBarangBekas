<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="price" id="price" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="tersedia">Tersedia</option>
                            <option value="terjual">Terjual</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Nomor WhatsApp / HP</label>
                        <input type="number" name="phone" id="phone" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="images" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                        <input type="file" name="image_path[]" id="images" multiple accept="image/*" onchange="if(this.files.length > 3){ alert('Maksimal hanya 3 gambar.'); this.value=''; }
                               class="mt-1 block w-full text-sm text-gray-500 file:bg-indigo-50 file:border file:border-gray-300 file:rounded file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100" />
                    </div>


                    <div class="flex space-x-3">
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            Simpan
                        </button>
                        <a href="{{ route('products.index') }}"
                           class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
