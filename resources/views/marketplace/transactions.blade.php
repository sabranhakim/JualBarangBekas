<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Transaksi Saya') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($orders as $order)
                <div class="bg-white rounded-xl shadow p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span
                            class="inline-flex self-start sm:self-auto px-3 py-1 rounded-full text-xs font-semibold {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700') }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="border border-gray-200 rounded-lg p-3 flex gap-3">
                                <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden shrink-0">
                                    @if ($item->product && $item->product->images->count())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->product->category->category_name ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    <p class="font-bold text-indigo-700">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-600 space-y-1">
                        <p><span class="font-semibold">Penerima:</span> {{ $order->receiver_name }}</p>
                        <p><span class="font-semibold">No HP:</span> {{ $order->phone }}</p>
                        <p><span class="font-semibold">Alamat:</span> {{ $order->address }}</p>
                        <p><span class="font-semibold">Catatan:</span> {{ $order->note ?: '-' }}</p>
                    </div>

                    @if ($order->status === 'pending')
                        <div class="mt-4">
                            <form action="{{ route('marketplace.retry-payment', $order) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition">
                                    Bayar Sekarang
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500 italic">
                    Kamu belum punya transaksi.
                </div>
            @endforelse

            <div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
