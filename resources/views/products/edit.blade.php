<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ $c->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $c->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="price" id="price" value="{{ $product->price }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="tersedia" {{ $product->status == 'tersedia' ? 'selected' : '' }}>Tersedia
                            </option>
                            <option value="terjual" {{ $product->status == 'terjual' ? 'selected' : '' }}>Terjual
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2 mt-1"
                            value="{{ old('phone', $product->phone ?? '') }}">
                    </div>


                    <div class="mb-4">
                        <label for="images_path" class="block text-sm font-medium text-gray-700">Tambah Gambar
                            Baru</label>
                        <input type="file" name="image_path[]" id="image_path" multiple
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" />
                        <p class="text-sm text-gray-500 mt-1">Boleh pilih lebih dari satu gambar.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                        <div class="flex flex-wrap mt-2">
                            @foreach ($product->images as $img)
                                <div class="relative inline-block m-2">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                        class="w-24 h-24 object-cover rounded">

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('product-images.destroy', $img->id) }}" method="POST"
                                        class="absolute top-0 right-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus gambar ini?')"
                                            class="bg-red-600 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center">
                                            &times;
                                        </button>
                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </div>



                    <div class="flex space-x-3">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            Update
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
