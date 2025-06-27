<x-guest-layout>
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 mt-10">
        <h2 class="text-center text-2xl font-extrabold text-indigo-700 mb-6">Login ke Akun Anda</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-300 focus:outline-none shadow-sm" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="text-sm text-indigo-600 hover:underline hover:text-indigo-800 transition">
                        Belum punya akun? Daftar
                    </a>
                @endif

                <x-primary-button class="w-full sm:w-auto px-6 py-2 text-sm bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
