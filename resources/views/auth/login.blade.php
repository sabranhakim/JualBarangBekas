<x-guest-layout>
    <div class="w-full max-w-md mx-auto space-y-6">
        <div class="text-center">
            <p class="inline-flex rounded-full px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700 mb-3">Welcome Back</p>
            <h2 class="text-3xl font-extrabold text-slate-900">Masuk ke akun kamu</h2>
            <p class="text-sm text-slate-500 mt-2">Kelola produk dan pantau aktivitas marketplace dari dashboard.</p>
        </div>

        <x-auth-session-status class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-2 text-sm" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-rose-600" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-rose-600" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer text-sm text-slate-600">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    Ingat saya
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-700 hover:text-blue-800 font-semibold">Lupa password?</a>
                @endif
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-slate-900 hover:bg-blue-700 text-white font-bold py-2.5 transition shadow-lg shadow-slate-900/15">
                Login
            </button>

            @if (Route::has('register'))
                <p class="text-center text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-700 hover:text-blue-800 font-semibold">Daftar sekarang</a>
                </p>
            @endif
        </form>
    </div>
</x-guest-layout>
