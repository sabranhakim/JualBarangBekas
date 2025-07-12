<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filter & Search --}}
                <form method="GET" action="{{ route('users.index') }}" class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center gap-3">

                        <div class="flex-1">
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="Cari pengguna..."
                                class="w-full px-4 py-2 rounded-md border border-indigo-300 shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-md shadow-sm transition">
                            Cari
                        </button>
                    </div>
                </form>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-sm rounded-lg shadow">
                        <thead>
                            <tr class="bg-indigo-500 text-white">
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">Role</th>
                                <th class="px-4 py-2 text-left">Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <x-user-row :user="$user" :index="$users->firstItem() + $index" />
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">
                                        Belum ada pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
