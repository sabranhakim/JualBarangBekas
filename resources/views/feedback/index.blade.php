<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Feedback Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-4">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded shadow text-sm">
                        <thead class="bg-indigo-100">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Pesan</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Dibuat</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedback as $i => $fb)
                                <tr class="{{ $fb->status === 'baru' ? 'bg-indigo-50' : '' }}">
                                    <td class="px-4 py-2">{{ $feedback->firstItem() + $i }}</td>
                                    <td class="px-4 py-2">{{ $fb->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $fb->email ?? '-' }}</td>
                                    <td class="px-4 py-2 max-w-xs break-words">{{ $fb->message }}</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="px-2 py-1 rounded text-xs
                                            {{ $fb->status === 'baru' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ ucfirst($fb->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $fb->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        @if($fb->status === 'baru')
                                        <form action="{{ route('feedback.updateStatus', $fb) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button
                                                class="px-2 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500 italic">Belum ada feedback.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $feedback->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
