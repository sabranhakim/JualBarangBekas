<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Category Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow border border-slate-100 p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Kategori</h3>
                        <p class="text-sm text-slate-500">Kelola kategori produk untuk marketplace.</p>
                    </div>
                    <a href="{{ route('categories.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">
                        + Tambah Kategori
                    </a>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-full text-sm bg-white">
                        <thead class="bg-slate-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Nama Kategori</th>
                                <th class="px-4 py-3 text-left font-semibold w-52">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $c)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                            {{ $c->category_name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('categories.edit', $c) }}"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-100 text-amber-700 hover:bg-amber-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus kategori?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-100 text-rose-700 hover:bg-rose-200 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-8 text-center text-slate-500 italic">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
