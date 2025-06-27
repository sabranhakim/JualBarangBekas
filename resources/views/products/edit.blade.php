<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-lg rounded-xl">
                <form
                    action="{{ route('products.update', $product) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    autocomplete="off"
                >
                    @csrf
                    @method('PUT')

                    {{-- Nama Produk --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-indigo-700">Nama Produk</label>
                        <input type="text" name="name" id="name" required
                            value="{{ old('name', $product->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400 text-sm" />
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-indigo-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400 text-sm">
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}" {{ $c->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $c->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-indigo-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400 text-sm">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-indigo-700">Harga</label>
                        <input type="number" name="price" id="price" required
                            value="{{ old('price', $product->price) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400 text-sm" />
                        @error('price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-indigo-700">Status</label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400 text-sm">
                            <option value="tersedia" {{ $product->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="terjual" {{ $product->status == 'terjual' ? 'selected' : '' }}>Terjual</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor WhatsApp --}}
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-indigo-700">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" id="phone" required
                            value="{{ old('phone', $product->phone ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400 text-sm" />
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tambah Gambar --}}
                    <div class="mb-4">
                        <label for="image_path" class="block text-sm font-medium text-indigo-700">Tambah Gambar Baru</label>
                        <input type="file" name="image_path[]" id="image_path" multiple accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:bg-indigo-50 file:border file:border-gray-300 file:rounded file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100" />
                        <p class="text-sm text-gray-500 mt-1">Maksimal 3 gambar.</p>
                        @error('image_path')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-3 ">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm transition">
                            Update
                        </button>
                        <a href="{{ route('products.index') }}"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md text-sm transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
