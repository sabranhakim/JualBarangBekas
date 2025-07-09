<x-guest-layout>
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border-t-4 border-indigo-600 p-8 space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-indigo-700 mb-2">Daftar Akun Baru</h1>
                <p class="text-sm text-gray-500">Buat akunmu sekarang dan mulai berjualan atau membeli.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-600 text-sm" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-sm" />
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-600 text-sm" />
                </div>

                <!-- Aksi -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-3">
                    <a href="{{ route('login') }}"
                        class="text-sm text-indigo-600 hover:underline hover:text-indigo-800 transition">
                        Sudah punya akun? <span class="font-semibold">Masuk</span>
                    </a>

                    <x-primary-button
                        class="w-full sm:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition focus:ring-2 focus:ring-indigo-400">
                        {{ __('Daftar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
</x-guest-layout>
