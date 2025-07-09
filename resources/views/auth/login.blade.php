<x-guest-layout>
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border-t-4 border-indigo-600 p-8 space-y-6">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-indigo-700">Login ke Akun Anda</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan email & password untuk masuk ke akun Anda.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="text-sm text-indigo-600 hover:underline hover:text-indigo-800 transition">
                            Belum punya akun? <span class="font-semibold">Daftar</span>
                        </a>
                    @endif

                    <x-primary-button
                        class="w-full sm:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition focus:ring-2 focus:ring-indigo-400">
                        {{ __('Login') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
</x-guest-layout>
