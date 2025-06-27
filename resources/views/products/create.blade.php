<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-800 leading-tight">
            {{ __(request()->routeIs('products.edit', $product ?? null) ? 'Edit Produk' : 'Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-lg ">
            <form action="{{ request()->routeIs('products.edit', $product ?? null) ? route('products.update', $product) : route('products.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6">

                @csrf
                @if(request()->routeIs('products.edit', $product ?? null))
                    @method('PUT')
                @endif

                {{-- Nama Produk --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm text-sm" />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">Kategori</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id', $product->category_id ?? '') == $c->id ? 'selected' : '' }}>
                                {{ $c->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm resize-none text-sm">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">Harga</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm text-sm" />
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">Status</label>
                    <select name="status" id="status" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm text-sm">
                        <option value="tersedia" {{ (old('status', $product->status ?? '') == 'tersedia') ? 'selected' : '' }}>Tersedia</option>
                        <option value="terjual" {{ (old('status', $product->status ?? '') == 'terjual') ? 'selected' : '' }}>Terjual</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $product->phone ?? '') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm text-sm" />
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label for="image_path" class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-700">{{ request()->routeIs('products.edit', $product ?? null) ? 'Tambah Gambar Baru' : 'Upload Gambar' }}</label>
                    <input type="file" name="image_path[]" id="image_path" multiple accept="image/*"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0 file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    <p class="text-xs text-gray-500 mt-1">Maksimal 3 gambar. Format: JPG, PNG.</p>
                    @error('image_path')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-5 py-2 rounded-lg transition text-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition text-sm">
                        {{ request()->routeIs('products.edit', $product ?? null) ? 'Update Produk' : 'Simpan Produk' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
