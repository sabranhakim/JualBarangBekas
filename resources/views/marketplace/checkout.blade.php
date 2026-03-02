<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Checkout Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-5">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Ringkasan Produk</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="h-64 bg-white rounded overflow-hidden mb-4">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="h-full flex items-center justify-center text-sm text-gray-400 italic">Tidak ada gambar</div>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-indigo-600">{{ $product->category->category_name ?? '-' }}</p>
                    <h4 class="font-bold text-gray-900 text-lg">{{ $product->name }}</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ $product->description }}</p>
                    <p class="text-sm text-gray-500 mt-2">Penjual: {{ $product->user->name ?? '-' }}</p>
                    <p class="text-xl font-extrabold text-green-700 mt-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Data Pengiriman</h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('marketplace.store-order', $product) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                        <input type="text" name="receiver_name" value="{{ old('receiver_name', auth()->user()->name) }}" required
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="address" rows="4" required
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">{{ old('address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                        <textarea name="note" rows="2"
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">{{ old('note') }}</textarea>
                    </div>

                    <input type="hidden" name="quantity" value="1">

                    <div class="bg-indigo-50 rounded-lg p-3 text-sm text-indigo-800">
                        Total transaksi: <span class="font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit"
                        class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                        Konfirmasi Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
