<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Sistem Absensi & HRIS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .premium-bg {
            background:
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.18), transparent 26%),
                radial-gradient(circle at 90% 15%, rgba(99, 102, 241, 0.16), transparent 28%),
                radial-gradient(circle at 50% 90%, rgba(14, 165, 233, 0.12), transparent 32%),
                linear-gradient(135deg, #f8fbff 0%, #eef5ff 45%, #e5ebf6 100%);
        }

        .digital-grid {
            background-image:
                linear-gradient(rgba(37, 99, 235, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.07) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.80);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
        }

        .brand-panel {
            background:
                linear-gradient(180deg, rgba(30, 64, 175, 0.95), rgba(17, 24, 39, 0.92));
        }

        .soft-input input {
            border-radius: 1rem !important;
            border: 1px solid #dbe2ea !important;
            background: rgba(255, 255, 255, 0.88) !important;
            padding-top: 0.85rem !important;
            padding-bottom: 0.85rem !important;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            box-shadow: none !important;
        }

        .soft-input input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12) !important;
        }

        .floating-orb {
            animation: floatOrb 6s ease-in-out infinite;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
    </style>
</head>

<body class="min-h-screen premium-bg text-slate-800">
    <div class="absolute inset-0 digital-grid opacity-70"></div>
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl"></div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-6xl rounded-[2rem] overflow-hidden glass-card grid grid-cols-1 lg:grid-cols-2">

            {{-- Kiri --}}
            <div class="hidden lg:flex relative brand-panel p-12 text-white flex-col justify-between">
                <div>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur border border-white/10 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h2 class="text-2xl font-black">Absensi HRIS</h2>
                            <p class="text-sm text-blue-100">Smart Attendance System</p>
                        </div>
                    </a>
                </div>

                <div class="py-10">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm font-bold mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Secure Login Portal
                    </span>

                    <h1 class="text-5xl font-black leading-tight mb-5">
                        Selamat datang kembali.
                    </h1>

                    <p class="text-blue-100 text-lg leading-relaxed max-w-md">
                        Masuk ke sistem untuk mengelola absensi QR Code berbasis GPS, cuti, lembur, dan slip gaji digital dengan lebih cepat dan terstruktur.
                    </p>

                   
                </div>

                <div class="text-sm text-blue-100">
                    © {{ date('Y') }} Sistem Absensi & HRIS
                </div>

                <div class="absolute top-10 right-10 w-28 h-28 rounded-full bg-cyan-300/20 blur-2xl floating-orb"></div>
                <div class="absolute bottom-16 right-16 w-20 h-20 rounded-full bg-indigo-300/20 blur-2xl floating-orb"></div>
            </div>

            {{-- Kanan --}}
            <div class="p-6 sm:p-10 lg:p-12 bg-white/50">
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ url('/') }}" class="inline-flex flex-col items-center">
                        <div class="w-20 h-20 rounded-3xl overflow-hidden shadow-lg">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                        </div>
                        <h2 class="mt-4 text-2xl font-black text-slate-950">Absensi HRIS</h2>
                        <p class="text-sm text-slate-500">Login ke sistem</p>
                    </a>
                </div>

                <div class="max-w-md mx-auto">
                    <div class="mb-8">
                        
                        <h3 class="text-3xl sm:text-4xl font-black text-slate-950 leading-tight">
                            Masuk ke akun Anda
                        </h3>
                        <p class="mt-3 text-slate-500 leading-relaxed">
                            Silakan masukkan email dan password untuk melanjutkan ke dashboard.
                        </p>
                        
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div class="soft-input">
                            <x-input-label for="email" :value="__('Email')" class="mb-2 font-semibold text-slate-700" />
                            <x-text-input
                                id="email"
                                class="block w-full"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan email Anda"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="soft-input">
                            <div class="flex items-center justify-between mb-2">
                                <x-input-label for="password" :value="__('Password')" class="font-semibold text-slate-700" />
                                @if (Route::has('password.request'))
                                    <a class="text-sm font-semibold text-blue-600 hover:text-blue-700" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>

                            <div class="relative">
                                <x-text-input
                                    id="password"
                                    class="block w-full pr-12"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                />
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-slate-700">
                                    👁️
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label for="remember_me" class="inline-flex items-center gap-2">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" name="remember">
                                <span class="text-sm text-slate-600 font-medium">{{ __('Ingat saya') }}</span>
                            </label>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-sm tracking-wide shadow-xl hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-1 transition duration-300">
                                LOG IN
                            </button>
                        </div>

                        @if (Route::has('register'))
                            <p class="text-center text-sm text-slate-500 pt-2">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700">
                                    Register sekarang
                                </a>
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
