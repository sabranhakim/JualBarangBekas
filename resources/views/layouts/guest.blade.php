<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-bg {
            background:
                radial-gradient(circle at 10% 15%, rgba(59, 130, 246, .24), transparent 40%),
                radial-gradient(circle at 90% 10%, rgba(34, 211, 238, .2), transparent 35%),
                radial-gradient(circle at 65% 85%, rgba(245, 158, 11, .16), transparent 35%),
                #f8fafc;
        }

        .auth-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="antialiased text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="min-h-screen auth-bg p-4 sm:p-8 lg:p-10 flex items-center justify-center">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-6 lg:gap-8 items-stretch">
            <section class="hidden lg:flex relative rounded-3xl overflow-hidden p-10 bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-800 text-white shadow-2xl">
                <div class="absolute -top-20 -right-16 w-72 h-72 rounded-full bg-cyan-300/20 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-20 w-72 h-72 rounded-full bg-blue-300/20 blur-3xl"></div>
                <div class="relative z-10 my-auto space-y-6">
                    <p class="inline-flex rounded-full px-3 py-1 text-xs font-bold bg-white/15 ring-1 ring-white/30">JualBarangBekas</p>
                    <h1 class="text-4xl font-extrabold leading-tight">Platform Modern untuk Jual Beli Barang Bekas</h1>
                    <p class="text-blue-100 max-w-md">Kelola produk lebih mudah, temukan pembeli lebih cepat, dan bangun kepercayaan lewat tampilan toko yang rapi.</p>
                    <div class="grid grid-cols-3 gap-3 max-w-sm">
                        <div class="rounded-xl bg-white/10 p-3 text-center">
                            <p class="text-2xl font-extrabold">Fast</p>
                            <p class="text-xs text-blue-100">Akses cepat</p>
                        </div>
                        <div class="rounded-xl bg-white/10 p-3 text-center">
                            <p class="text-2xl font-extrabold">Safe</p>
                            <p class="text-xs text-blue-100">Aman dipakai</p>
                        </div>
                        <div class="rounded-xl bg-white/10 p-3 text-center">
                            <p class="text-2xl font-extrabold">Simple</p>
                            <p class="text-xs text-blue-100">UI clean</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="auth-glass rounded-3xl shadow-xl p-5 sm:p-8 lg:p-10 flex items-center">
                <div class="w-full">
                    {{ $slot }}
                </div>
            </section>
        </div>
    </div>
</body>

</html>
