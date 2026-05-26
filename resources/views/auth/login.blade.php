<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Sistem Absensi & HRIS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .premium-bg {
            background:
                radial-gradient(circle at 10% 20%, rgba(26, 47, 107, 0.18), transparent 26%),
                radial-gradient(circle at 90% 15%, rgba(45, 168, 74, 0.14), transparent 28%),
                radial-gradient(circle at 50% 90%, rgba(30, 95, 168, 0.10), transparent 32%),
                linear-gradient(135deg, #f0f4ff 0%, #eaf5ee 45%, #dbeafe 100%);
        }

        .digital-grid {
            background-image:
                linear-gradient(rgba(26, 47, 107, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(26, 47, 107, 0.07) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .glass-card {
            background: rgba(252, 253, 255, 0.96);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 40px rgba(15, 23, 42, 0.10);
        }

        .brand-panel {
            background:
                linear-gradient(155deg, rgba(26, 47, 107, 0.97) 0%, rgba(10, 30, 70, 0.95) 50%, rgba(15, 60, 30, 0.90) 100%);
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
            border-color: #1a2f6b !important;
            box-shadow: 0 0 0 4px rgba(26, 47, 107, 0.12) !important;
        }

        .floating-orb {
            animation: floatOrb 6s ease-in-out infinite;
            will-change: transform;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        /* Page Loader */
        #page-loader {
            position: fixed; inset: 0; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #f0f4ff 0%, #eaf5ee 100%);
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }
        #page-loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .loader-ring {
            width: 44px; height: 44px;
            border: 4px solid rgba(26, 47, 107, 0.15);
            border-top-color: #1a2f6b;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>

<body class="min-h-screen premium-bg text-slate-800">

    <div id="page-loader">
        <div class="text-center">
            <div class="loader-ring mx-auto"></div>
            <p class="mt-4 text-sm font-semibold text-slate-500">Memuat...</p>
        </div>
    </div>
    <div class="absolute inset-0 digital-grid opacity-70"></div>
    <div class="absolute top-0 left-0 w-48 h-48 rounded-full blur-2xl" style="background:rgba(26,47,107,0.15)"></div>
    <div class="absolute bottom-0 right-0 w-56 h-56 rounded-full blur-2xl" style="background:rgba(45,168,74,0.15)"></div>

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
                            <p class="text-sm" style="color:rgba(167,220,180,0.9)">Smart Attendance System</p>
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

                    <p class="text-lg leading-relaxed max-w-md" style="color:rgba(200,225,210,0.9)">
                        Masuk ke sistem untuk mengelola absensi QR Code berbasis GPS, cuti, lembur, dan slip gaji digital dengan lebih cepat dan terstruktur.
                    </p>

                   
                </div>

                <div class="text-sm" style="color:rgba(180,215,195,0.85)">
                    © {{ date('Y') }} Sistem Absensi & HRIS
                </div>

                <div class="absolute top-10 right-10 w-28 h-28 rounded-full blur-2xl floating-orb" style="background:rgba(45,168,74,0.25)"></div>
                <div class="absolute bottom-16 right-16 w-20 h-20 rounded-full blur-2xl floating-orb" style="background:rgba(30,95,168,0.20)"></div>
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
                                    <a class="text-sm font-semibold hover:underline" href="{{ route('password.request') }}" style="color:#1a2f6b">
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
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 focus:ring-2" style="color:#1a2f6b;accent-color:#1a2f6b" name="remember">
                                <span class="text-sm text-slate-600 font-medium">{{ __('Ingat saya') }}</span>
                            </label>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-4 rounded-2xl text-white font-black text-sm tracking-wide shadow-xl hover:-translate-y-1 transition duration-300" style="background:linear-gradient(to right,#1a2f6b,#2da84a)">
                                LOG IN
                            </button>
                        </div>

                        @if (Route::has('register'))
                            <p class="text-center text-sm text-slate-500 pt-2">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="font-bold hover:underline" style="color:#1a2f6b">
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
        document.addEventListener('DOMContentLoaded', function () {
            var loader = document.getElementById('page-loader');
            if (loader) loader.classList.add('hidden');
        });
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
