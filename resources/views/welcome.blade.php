<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Absensi & HRIS</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
        }

        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }
    </script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .premium-bg {
            background:
                radial-gradient(circle at 18% 20%, rgba(26, 47, 107, 0.15), transparent 26%),
                radial-gradient(circle at 85% 25%, rgba(45, 168, 74, 0.12), transparent 28%),
                radial-gradient(circle at 50% 90%, rgba(30, 95, 168, 0.08), transparent 34%),
                linear-gradient(135deg, rgba(240, 244, 255, 0.88) 0%, rgba(234, 245, 238, 0.88) 45%, rgba(219, 234, 254, 0.88) 100%),
                url("{{ asset('images/gedung.jpg') }}") no-repeat center center / cover;
            background-attachment: fixed;
        }

        .dark .premium-bg {
            background:
                radial-gradient(circle at 18% 20%, rgba(26, 47, 107, 0.22), transparent 26%),
                radial-gradient(circle at 85% 25%, rgba(45, 168, 74, 0.15), transparent 28%),
                radial-gradient(circle at 50% 90%, rgba(30, 95, 168, 0.10), transparent 34%),
                linear-gradient(135deg, rgba(5, 9, 26, 0.92) 0%, rgba(8, 16, 32, 0.92) 48%, rgba(6, 14, 18, 0.92) 100%),
                url("{{ asset('images/gedung.jpg') }}") no-repeat center center / cover;
            background-attachment: fixed;
        }

        .digital-grid {
            background-image:
                linear-gradient(rgba(26, 47, 107, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(26, 47, 107, 0.08) 1px, transparent 1px);
            background-size: 46px 46px;
            mask-image: linear-gradient(to bottom, black 0%, transparent 78%);
        }

        .dark .digital-grid {
            background-image:
                linear-gradient(rgba(45, 168, 74, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45, 168, 74, 0.08) 1px, transparent 1px);
        }

        .glass {
            background: rgba(250, 250, 249, 0.92);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.80);
            box-shadow: 0 8px 40px rgba(15, 23, 42, 0.10);
        }

        .dark .glass {
            background: rgba(15, 23, 20, 0.90);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.30);
        }

        .soft-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(231, 229, 228, 0.95);
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08);
        }

        .dark .soft-card {
            background: rgba(15, 23, 20, 0.95);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        @keyframes floatUp {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-14px); }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 rgba(26, 47, 107, 0.0); }
            50% { box-shadow: 0 0 45px rgba(26, 47, 107, 0.35); }
        }

        .float-up {
            animation: floatUp 5.5s ease-in-out infinite;
            will-change: transform;
        }

        .pulse-glow {
            animation: pulseGlow 4s ease-in-out infinite;
            will-change: box-shadow;
        }

        /* Page Loader */
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f4ff 0%, #eaf5ee 100%);
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }
        .dark #page-loader {
            background: linear-gradient(135deg, #05091a 0%, #081020 100%);
        }
        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-ring {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(26, 47, 107, 0.15);
            border-top-color: #1a2f6b;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Lazy sections */
        .lazy-section {
            content-visibility: auto;
            contain-intrinsic-size: 0 400px;
        }
    </style>
</head>

<body class="min-h-screen premium-bg text-slate-800 dark:text-slate-100 transition-colors duration-500">

    {{-- Page Loader --}}
    <div id="page-loader">
        <div class="text-center">
            <div class="loader-ring mx-auto"></div>
            <p class="mt-4 text-sm font-semibold text-slate-500 dark:text-slate-400">Memuat...</p>
        </div>
    </div>

    <main class="relative min-h-screen overflow-hidden">

        {{-- Background digital --}}
        <div class="absolute inset-0 digital-grid opacity-80"></div>
        <div class="absolute -top-36 -left-24 w-64 h-64 rounded-full blur-2xl" style="background:rgba(26,47,107,0.15)"></div>
        <div class="absolute top-28 -right-24 w-64 h-64 rounded-full blur-2xl" style="background:rgba(45,168,74,0.15)"></div>

        {{-- Navbar --}}
        <nav class="relative z-50 px-5 pt-6">
            <div class="max-w-7xl mx-auto h-20 px-5 md:px-7 rounded-[1.75rem] glass flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-2xl object-contain pulse-glow">

                    <div>
                        <h1 class="text-lg md:text-xl font-black text-slate-950 dark:text-white leading-tight">
                            Absensi HRIS
                        </h1>
                        <p class="hidden sm:block text-xs text-slate-500 dark:text-slate-400">
                            Smart Attendance System
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-5 md:px-6 py-3 rounded-2xl text-white font-black shadow-xl hover:-translate-y-1 transition" style="background:linear-gradient(to right,#1a2f6b,#1e5fa8)">
                            Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 md:px-6 py-3 rounded-2xl bg-white/90 dark:bg-slate-800 text-slate-900 dark:text-white font-black border border-slate-200 dark:border-slate-700 hover:-translate-y-1 hover:shadow-xl transition">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="hidden sm:inline-flex px-5 md:px-6 py-3 rounded-2xl text-white font-black shadow-xl hover:-translate-y-1 transition" style="background:linear-gradient(to right,#1a2f6b,#1e5fa8)">
                                Register →
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <section class="relative z-10 max-w-7xl mx-auto px-6 lg:px-10 pt-16 md:pt-20 pb-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                {{-- Left hero --}}
                <div class="lg:col-span-7 text-center lg:text-left">

                    <img src="{{ asset('images/logo.png') }}" alt="Sistem Absensi & HRIS Digital" class="-my-4 max-w-xs md:max-w-sm lg:max-w-md w-full h-auto object-contain" style="max-height:220px">

                    <p class="mt-7 text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto lg:mx-0 leading-relaxed">
                        Platform manajemen absensi QR Code berbasis GPS, cuti, lembur, dan slip gaji digital
                        yang modern, aman, dan mudah digunakan untuk kebutuhan perusahaan PT Defourd Sejahtera Bersama.
                    </p>

                    <div class="mt-10 flex justify-center lg:justify-start gap-4 flex-wrap">
                        <a href="{{ route('login') }}"
                           class="px-8 py-4 rounded-2xl text-white font-black shadow-2xl hover:-translate-y-1 transition" style="background:linear-gradient(to right,#1a2f6b,#2da84a)">
                            Masuk Sekarang →
                        </a>
                    </div>

                    {{-- Mini stats --}}
                    <div class="mt-10 grid grid-cols-3 gap-4 max-w-xl mx-auto lg:mx-0">
                        <div class="soft-card rounded-2xl p-4 text-center">
                            <h3 class="text-2xl font-black text-slate-950 dark:text-white">GPS</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Validasi Lokasi</p>
                        </div>
                        <div class="soft-card rounded-2xl p-4 text-center">
                            <h3 class="text-2xl font-black text-slate-950 dark:text-white">QR</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Scan Absensi</p>
                        </div>
                        <div class="soft-card rounded-2xl p-4 text-center">
                            <h3 class="text-2xl font-black text-slate-950 dark:text-white">PDF</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Slip Gaji</p>
                        </div>
                    </div>
                </div>

                {{-- Right visual dashboard --}}
                <div class="lg:col-span-5">
                    <div class="relative max-w-md mx-auto float-up">
                        <div class="absolute -inset-5 rounded-[2.5rem] blur-2xl" style="background:linear-gradient(to right,rgba(26,47,107,0.20),rgba(45,168,74,0.15))"></div>

                        <div class="relative glass rounded-[2rem] p-5">
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-semibold">Dashboard Preview</p>
                                    <h3 class="text-2xl font-black text-slate-950 dark:text-white">HRIS Overview</h3>
                                </div>
                                <div class="w-12 h-12 rounded-2xl text-white flex items-center justify-center text-2xl shadow-lg" style="background:linear-gradient(135deg,#1a2f6b,#1e5fa8)">
                                    📊
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="rounded-3xl text-white p-5 shadow-lg" style="background:linear-gradient(135deg,#1a2f6b,#1e5fa8)">
                                    <p class="text-sm opacity-80">Hadir Hari Ini</p>
                                    <h4 class="text-4xl font-black mt-2">{{ $hadirHariIniPersen }}%</h4>
                                </div>
                                <div class="rounded-3xl bg-white/85 dark:bg-slate-800 p-5 border border-slate-100 dark:border-slate-700">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Cuti Aktif</p>
                                    <h4 class="text-4xl font-black mt-2 text-slate-950 dark:text-white">{{ $cutiAktifCount }}</h4>
                                </div>
                            </div>

                            <div class="rounded-3xl bg-white/85 dark:bg-slate-800 p-5 border border-slate-100 dark:border-slate-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-black text-slate-950 dark:text-white">Aktivitas Absensi</h4>
                                    <span class="text-xs px-3 py-1 rounded-full font-black" style="background:#edfff2;color:#2da84a">Live</span>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-slate-600 dark:text-slate-300">QR Check-in</span>
                                            <span class="font-black" style="color:#1a2f6b">{{ $qrCheckInPersen }}%</span>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ $qrCheckInPersen }}%; background:linear-gradient(to right,#1a2f6b,#1e5fa8)"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-slate-600 dark:text-slate-300">Valid GPS</span>
                                            <span class="font-black" style="color:#2da84a">{{ $validGpsPersen }}%</span>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ $validGpsPersen }}%; background:linear-gradient(to right,#2da84a,#166534)"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-slate-600 dark:text-slate-300">Slip Gaji</span>
                                            <span class="font-black" style="color:#1e5fa8">{{ $slipGajiPersen }}%</span>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ $slipGajiPersen }}%; background:linear-gradient(to right,#1e5fa8,#2da84a)"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div class="rounded-2xl bg-white/85 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-3 text-center">
                                    <div class="text-2xl">📱</div>
                                    <p class="text-xs mt-1 font-bold text-slate-500 dark:text-slate-400">QR</p>
                                </div>
                                <div class="rounded-2xl bg-white/85 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-3 text-center">
                                    <div class="text-2xl">📍</div>
                                    <p class="text-xs mt-1 font-bold text-slate-500 dark:text-slate-400">GPS</p>
                                </div>
                                <div class="rounded-2xl bg-white/85 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-3 text-center">
                                    <div class="text-2xl">💰</div>
                                    <p class="text-xs mt-1 font-bold text-slate-500 dark:text-slate-400">Payroll</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <script>
        // Hide loader as soon as DOM is ready
        document.addEventListener('DOMContentLoaded', function () {
            var loader = document.getElementById('page-loader');
            if (loader) loader.classList.add('hidden');
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</body>
</html>