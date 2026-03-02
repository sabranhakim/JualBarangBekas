<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Feedback Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow border border-slate-100 p-4 sm:p-5">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Feedback Pengguna</h3>
                        <p class="text-sm text-slate-500">Pantau masukan baru dan tandai feedback yang sudah dibaca.</p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-full text-sm bg-white">
                        <thead class="bg-slate-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">Pengirim</th>
                                <th class="px-4 py-3 text-left font-semibold">Pesan</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($feedback as $i => $fb)
                                <tr class="{{ $fb->status === 'baru' ? 'bg-indigo-50/60' : 'hover:bg-slate-50' }} transition">
                                    <td class="px-4 py-3">{{ $feedback->firstItem() + $i }}</td>
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-slate-800">{{ $fb->name ?? 'Anonim' }}</p>
                                        <p class="text-xs text-slate-500">{{ $fb->email ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-3 max-w-md text-slate-700">{{ $fb->message }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $fb->status === 'baru' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ strtoupper($fb->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">{{ $fb->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if($fb->status === 'baru')
                                            <form action="{{ route('feedback.updateStatus', $fb) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs rounded-lg font-semibold transition">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-slate-500 italic">Belum ada feedback.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $feedback->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
