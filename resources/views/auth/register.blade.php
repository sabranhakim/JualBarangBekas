<x-guest-layout>
    <div class="w-full max-w-md mx-auto space-y-6">
        <div class="text-center">
            <p class="inline-flex rounded-full px-3 py-1 text-xs font-bold bg-cyan-100 text-cyan-700 mb-3">Create Account</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Buat akun baru</h1>
            <p class="text-sm text-slate-500 mt-2">Daftar untuk mulai menjual atau membeli barang bekas dengan mudah.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-200 focus:border-cyan-500 transition" />
                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-sm text-rose-600" />
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-200 focus:border-cyan-500 transition" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-rose-600" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-200 focus:border-cyan-500 transition" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-rose-600" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-200 focus:border-cyan-500 transition" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-sm text-rose-600" />
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-slate-900 hover:bg-cyan-700 text-white font-bold py-2.5 transition shadow-lg shadow-slate-900/15">
                Daftar
            </button>

            <p class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-cyan-700 hover:text-cyan-800 font-semibold">Masuk sekarang</a>
            </p>
        </form>
    </div>
</x-guest-layout>
