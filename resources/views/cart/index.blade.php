<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Keranjang Saya') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Item Keranjang</h3>

                @if ($items->isEmpty())
                    <div class="p-6 rounded-lg bg-gray-50 text-center text-gray-500 italic">
                        Keranjang kamu masih kosong.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($items as $item)
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item['name'] ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] ?? 1 }}</p>
                                </div>
                                <p class="font-bold text-indigo-700">
                                    Rp {{ number_format((float) ($item['price'] ?? 0), 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
