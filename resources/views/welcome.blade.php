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
                radial-gradient(circle at 18% 20%, rgba(37, 99, 235, 0.22), transparent 26%),
                radial-gradient(circle at 85% 25%, rgba(99, 102, 241, 0.20), transparent 28%),
                radial-gradient(circle at 50% 90%, rgba(14, 165, 233, 0.13), transparent 34%),
                linear-gradient(135deg, #f8fbff 0%, #eef5ff 45%, #e5ebf6 100%);
        }

        .dark .premium-bg {
            background:
                radial-gradient(circle at 18% 20%, rgba(37, 99, 235, 0.20), transparent 26%),
                radial-gradient(circle at 85% 25%, rgba(99, 102, 241, 0.16), transparent 28%),
                radial-gradient(circle at 50% 90%, rgba(14, 165, 233, 0.10), transparent 34%),
                linear-gradient(135deg, #020617 0%, #0f172a 48%, #111827 100%);
        }

        .digital-grid {
            background-image:
                linear-gradient(rgba(37, 99, 235, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.08) 1px, transparent 1px);
            background-size: 46px 46px;
            mask-image: linear-gradient(to bottom, black 0%, transparent 78%);
        }

        .dark .digital-grid {
            background-image:
                linear-gradient(rgba(96, 165, 250, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(96, 165, 250, 0.08) 1px, transparent 1px);
        }

        .glass {
            background: rgba(248, 251, 255, 0.92);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.80);
            box-shadow: 0 8px 40px rgba(15, 23, 42, 0.10);
        }

        .dark .glass {
            background: rgba(15, 23, 42, 0.90);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.30);
        }

        .soft-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08);
        }

        .dark .soft-card {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        @keyframes floatUp {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-14px);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 0 rgba(37, 99, 235, 0.0);
            }
            50% {
                box-shadow: 0 0 45px rgba(37, 99, 235, 0.25);
            }
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
            background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }
        .dark #page-loader {
            background: linear-gradient(135deg, #020617 0%, #0f172a 100%);
        }
        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-ring {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(37, 99, 235, 0.15);
            border-top-color: #2563eb;
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
        <div class="absolute -top-36 -left-24 w-64 h-64 rounded-full bg-blue-400/15 blur-2xl"></div>
        <div class="absolute top-28 -right-24 w-64 h-64 rounded-full bg-indigo-400/15 blur-2xl"></div>

        {{-- Navbar --}}
        <nav class="relative z-50 px-5 pt-6">
            <div class="max-w-7xl mx-auto h-20 px-5 md:px-7 rounded-[1.75rem] glass flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-lg pulse-glow">
                        A
                    </div>

                    <div>
                        <h1 class="text-lg md:text-xl font-black text-slate-950 dark:text-white leading-tight">
                            Absensi HRIS
                        </h1>
                        <p class="hidden sm:block text-xs text-slate-500 dark:text-slate-400">
                            Smart Attendance System
                        </p>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-11 font-bold text-slate-600 dark:text-slate-300">
                    <a href="#" class="relative text-blue-600 dark:text-blue-400">
                        Beranda
                        <span class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    </a>
                    <a href="#fitur" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Fitur</a>
                    <a href="#tentang" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Tentang</a>
                    <a href="#keunggulan" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Keunggulan</a>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="toggleTheme()"
                        class="w-12 h-12 rounded-2xl bg-white/85 dark:bg-slate-800 text-slate-900 dark:text-yellow-300 border border-slate-200 dark:border-slate-700 font-bold hover:-translate-y-1 hover:shadow-xl transition">
                        🌙
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-5 md:px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black hover:from-blue-700 hover:to-indigo-700 shadow-xl hover:-translate-y-1 transition">
                            Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 md:px-6 py-3 rounded-2xl bg-white/90 dark:bg-slate-800 text-slate-900 dark:text-white font-black border border-slate-200 dark:border-slate-700 hover:-translate-y-1 hover:shadow-xl transition">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="hidden sm:inline-flex px-5 md:px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black shadow-xl hover:-translate-y-1 hover:from-blue-700 hover:to-indigo-700 transition">
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
                   

                    <h1 class="mt-5 text-4xl md:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 dark:text-white leading-[1.50] pb-4">
                        Sistem Absensi
                        <span class="block bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 bg-clip-text text-transparent pb-4 leading-[1.25]">
                    & HRIS Digital
                    </span>
                    </h1>

                    <p class="mt-7 text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto lg:mx-0 leading-relaxed">
                        Platform manajemen absensi QR Code berbasis GPS, cuti, lembur, dan slip gaji digital
                        yang modern, aman, dan mudah digunakan untuk kebutuhan perusahaan.
                    </p>

                    <div class="mt-10 flex justify-center lg:justify-start gap-4 flex-wrap">
                        <a href="{{ route('login') }}"
                           class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black shadow-2xl hover:-translate-y-1 hover:from-blue-700 hover:to-indigo-700 transition">
                            Masuk Sekarang →
                        </a>

                        <a href="#fitur"
                           class="px-8 py-4 rounded-2xl bg-white/90 dark:bg-slate-900/80 text-blue-700 dark:text-blue-300 font-black border border-blue-100 dark:border-slate-700 hover:-translate-y-1 hover:shadow-xl transition">
                            ⊞ Lihat Fitur
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
                        <div class="absolute -inset-5 rounded-[2.5rem] bg-gradient-to-r from-blue-500/20 to-indigo-500/20 blur-2xl"></div>

                        <div class="relative glass rounded-[2rem] p-5">
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-semibold">Dashboard Preview</p>
                                    <h3 class="text-2xl font-black text-slate-950 dark:text-white">HRIS Overview</h3>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center text-2xl shadow-lg">
                                    📊
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="rounded-3xl bg-blue-600 text-white p-5 shadow-lg">
                                    <p class="text-sm opacity-80">Hadir Hari Ini</p>
                                    <h4 class="text-4xl font-black mt-2">92%</h4>
                                </div>
                                <div class="rounded-3xl bg-white/85 dark:bg-slate-800 p-5 border border-slate-100 dark:border-slate-700">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Cuti Aktif</p>
                                    <h4 class="text-4xl font-black mt-2 text-slate-950 dark:text-white">12</h4>
                                </div>
                            </div>

                            <div class="rounded-3xl bg-white/85 dark:bg-slate-800 p-5 border border-slate-100 dark:border-slate-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-black text-slate-950 dark:text-white">Aktivitas Absensi</h4>
                                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-black">Live</span>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-slate-600 dark:text-slate-300">QR Check-in</span>
                                            <span class="font-black text-blue-600">86%</span>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <div class="h-full w-[86%] rounded-full bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-slate-600 dark:text-slate-300">Valid GPS</span>
                                            <span class="font-black text-emerald-600">94%</span>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <div class="h-full w-[94%] rounded-full bg-gradient-to-r from-emerald-500 to-green-500"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-bold text-slate-600 dark:text-slate-300">Slip Gaji</span>
                                            <span class="font-black text-violet-600">78%</span>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <div class="h-full w-[78%] rounded-full bg-gradient-to-r from-violet-500 to-purple-500"></div>
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

        {{-- Tentang --}}
        <section id="tentang" class="lazy-section relative z-10 max-w-6xl mx-auto px-6 lg:px-10 mt-8">
            <div class="glass rounded-[2rem] p-6 md:p-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-4">
                    <div class="relative h-56 rounded-[1.75rem] bg-gradient-to-br from-blue-100 via-white to-indigo-100 dark:from-blue-950 dark:via-slate-900 dark:to-indigo-950 border border-white/70 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 digital-grid opacity-60"></div>
                        <div class="relative text-8xl float-up"><img src="{{ asset('images/gedung.png') }}"
     alt="Ilustrasi Sistem Absensi HRIS"
     loading="lazy"
     decoding="async"
     class="relative w-45 h-45 object-contain float-up"></div>
                    </div>
                </div>

                <div class="md:col-span-8 text-center md:text-left">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 font-black mb-5">
                        <span>🏢</span>
                        <span>Tentang Project</span>
                    </div>

                    <h2 class="text-3xl md:text-4xl font-black text-slate-950 dark:text-white leading-tight mb-4">
                        Sistem absensi digital untuk proses kerja yang lebih rapi dan terukur.
                    </h2>

                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                        Sistem ini dibangun untuk membantu perusahaan dalam mengelola absensi karyawan
                        menggunakan QR Code berbasis GPS, pengajuan cuti, manajemen lembur, serta pembuatan
                        slip gaji secara digital dan terstruktur. Dengan tampilan modern dan alur yang sederhana,
                        sistem ini mendukung kebutuhan operasional HR agar lebih cepat, aman, dan terdokumentasi.
                    </p>
                </div>
            </div>
        </section>

        {{-- Fitur --}}
        <section id="fitur" class="lazy-section relative z-10 max-w-7xl mx-auto px-6 lg:px-10 mt-10 pb-10">
            <div class="text-center mb-8">
                <span class="inline-flex px-4 py-2 rounded-full bg-white/70 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700 font-black text-blue-700 dark:text-blue-300 text-sm">
                    Fitur Utama
                </span>
                <h2 class="mt-4 text-3xl md:text-5xl font-black text-slate-950 dark:text-white">
                    Semua kebutuhan HR dalam satu sistem
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7">
                @php
                    $features = [
                        [
                            'icon' => '📱',
                            'title' => 'Absensi QR Code berbasis GPS',
                            'desc' => 'Absensi dilakukan dengan scan QR Code dan divalidasi berdasarkan lokasi GPS secara realtime.',
                            'color' => 'from-blue-100 to-indigo-100',
                            'line' => 'from-blue-600 to-indigo-600',
                        ],
                        [
                            'icon' => '⏱️',
                            'title' => 'Manajemen Lembur',
                            'desc' => 'Pengajuan dan approval lembur lebih mudah, jelas, dan terstruktur.',
                            'color' => 'from-emerald-100 to-green-100',
                            'line' => 'from-emerald-500 to-green-500',
                        ],
                        [
                            'icon' => '📝',
                            'title' => 'Cuti Online',
                            'desc' => 'Ajukan cuti dan izin langsung dari sistem kapan saja dengan alur approval.',
                            'color' => 'from-orange-100 to-amber-100',
                            'line' => 'from-orange-500 to-amber-500',
                        ],
                        [
                            'icon' => '💰',
                            'title' => 'Slip Gaji PDF',
                            'desc' => 'Generate slip gaji digital otomatis dalam format PDF yang rapi dan aman.',
                            'color' => 'from-violet-100 to-purple-100',
                            'line' => 'from-violet-500 to-purple-500',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div class="group relative soft-card rounded-[2rem] p-8 text-center transition duration-300 hover:-translate-y-3 hover:shadow-2xl overflow-hidden">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $feature['line'] }}"></div>
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-blue-400/10 blur-2xl group-hover:bg-blue-500/20 transition"></div>

                        <div class="relative w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br {{ $feature['color'] }} flex items-center justify-center text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition duration-300 shadow-sm">
                            {{ $feature['icon'] }}
                        </div>

                        <h3 class="relative text-xl font-black text-slate-950 dark:text-white mb-4 leading-snug">
                            {{ $feature['title'] }}
                        </h3>

                        <p class="relative text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                            {{ $feature['desc'] }}
                        </p>

                        <a href="#"
                           class="relative mt-7 mx-auto w-11 h-11 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-blue-600 dark:text-blue-300 font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition">
                            →
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Keunggulan --}}
        <section id="keunggulan" class="lazy-section relative z-10 max-w-7xl mx-auto px-6 lg:px-10 pb-16">
            <div class="glass rounded-[2rem] p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div class="p-6 rounded-3xl bg-white/65 dark:bg-slate-800/65 border border-slate-100 dark:border-slate-700">
                        <div class="text-4xl mb-3">⚡</div>
                        <h3 class="font-black text-xl text-slate-950 dark:text-white">Proses Cepat</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Absensi, cuti, lembur, dan slip gaji lebih efisien.</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-white/65 dark:bg-slate-800/65 border border-slate-100 dark:border-slate-700">
                        <div class="text-4xl mb-3">🛡️</div>
                        <h3 class="font-black text-xl text-slate-950 dark:text-white">Lebih Aman</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Validasi QR dan GPS membantu mengurangi manipulasi absensi.</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-white/65 dark:bg-slate-800/65 border border-slate-100 dark:border-slate-700">
                        <div class="text-4xl mb-3">📈</div>
                        <h3 class="font-black text-xl text-slate-950 dark:text-white">Data Terdokumentasi</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Riwayat absensi dan laporan tersimpan secara terstruktur.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="relative z-10 border-t border-white/60 dark:border-slate-700/60 bg-white/45 dark:bg-slate-900/45 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-center text-sm text-slate-600 dark:text-slate-300">
                <div>
                    Dibuat oleh Raffuad Munawir
                </div>

                <div>
                    <a href="https://github.com/Raffuad" target="_blank" class="font-black text-blue-600 dark:text-blue-300 hover:underline">
                        Lihat Project di GitHub →
                    </a>
                </div>

                <div>
                    Powered by Laravel 12 & Tailwind CSS
                </div>
            </div>
        </footer>

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