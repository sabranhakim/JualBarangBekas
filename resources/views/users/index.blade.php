<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('error'))
                <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-2xl shadow border border-slate-100 p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Pengguna</h3>
                        <p class="text-sm text-slate-500">Total data: {{ $users->total() }}</p>
                    </div>

                    <form method="GET" action="{{ route('users.index') }}" class="w-full sm:w-auto sm:min-w-[320px]">
                        <div class="flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..."
                                class="w-full px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                            <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-full text-sm bg-white">
                        <thead class="bg-slate-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                <th class="px-4 py-3 text-left font-semibold">Email</th>
                                <th class="px-4 py-3 text-left font-semibold">Role</th>
                                <th class="px-4 py-3 text-left font-semibold">Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($users as $index => $user)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3">{{ $users->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 text-xs rounded-full font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-sky-100 text-sky-700' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-500 italic">Belum ada pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
