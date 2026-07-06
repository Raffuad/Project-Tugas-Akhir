<?php
/**
 * @var int $hadirHariIniPersen
 * @var int $cutiAktifCount
 * @var int $absensiPersen
 * @var int $cutiPersen
 * @var int $laporanPersen
 */
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', \Illuminate\Support\Facades\App::getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Absensi HRIS DSB</title>

    <link rel="icon" type="image/png" href="{{ \Illuminate\Support\Facades\URL::asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .premium-bg {
            background:
                radial-gradient(circle at 12% 15%, rgba(26, 47, 107, 0.08), transparent 30%),
                radial-gradient(circle at 88% 25%, rgba(45, 168, 74, 0.06), transparent 30%),
                radial-gradient(circle at 50% 85%, rgba(30, 95, 168, 0.04), transparent 35%),
                linear-gradient(135deg, rgba(245, 248, 255, 0.94) 0%, rgba(238, 247, 242, 0.94) 50%, rgba(232, 242, 255, 0.94) 100%),
                url("{{ \Illuminate\Support\Facades\URL::asset('images/gedung.jpg') }}") no-repeat center center / cover;
            background-attachment: fixed;
        }

        .digital-grid {
            background-image:
                linear-gradient(rgba(26, 47, 107, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(26, 47, 107, 0.05) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, black 25%, transparent 88%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 12px 35px -8px rgba(15, 23, 42, 0.08);
        }

        .soft-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 18px -4px rgba(15, 23, 42, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .soft-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -8px rgba(15, 23, 42, 0.1);
        }

        @keyframes floatUp {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .float-up {
            animation: floatUp 6.5s ease-in-out infinite;
            will-change: transform;
        }

        .pulse-glow {
            box-shadow: 0 0 20px rgba(26, 47, 107, 0.06);
            transition: all 0.3s ease;
        }

        .pulse-glow:hover {
            box-shadow: 0 0 25px rgba(26, 47, 107, 0.15);
        }

        /* Page Loader */
        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-ring {
            width: 44px;
            height: 44px;
            border: 3.5px solid rgba(26, 47, 107, 0.08);
            border-top-color: #1a2f6b;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>

<body class="min-h-screen premium-bg text-slate-800 transition-colors duration-300">

    {{-- Page Loader --}}
    <div id="page-loader">
        <div class="text-center">
            <div class="loader-ring mx-auto"></div>
            <p class="mt-4 text-xs font-bold uppercase tracking-widest text-slate-400">PT Defourd Sejahtera Bersama</p>
        </div>
    </div>

    <main class="relative min-h-screen overflow-hidden">

        {{-- Background digital --}}
        <div class="absolute inset-0 digital-grid opacity-90"></div>
        <div class="absolute -top-36 -left-24 w-72 h-72 rounded-full blur-3xl" style="background:rgba(26,47,107,0.1)"></div>
        <div class="absolute top-28 -right-24 w-72 h-72 rounded-full blur-3xl" style="background:rgba(45,168,74,0.08)"></div>

        {{-- Navbar --}}
        <nav class="relative z-50 px-5 pt-6">
            <div class="max-w-7xl mx-auto h-20 px-5 md:px-7 rounded-[1.75rem] glass flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-1 bg-white rounded-xl shadow-sm border border-transparent">
                        <img src="{{ \Illuminate\Support\Facades\URL::asset('images/logo.png') }}" alt="Logo" class="w-11 h-11 object-contain">
                    </div>

                    <div>
                        <h1 class="text-base md:text-lg font-black tracking-wider text-slate-900 uppercase leading-none">
                            DEFOURD HR SYSTEM
                        </h1>
                        <p class="hidden sm:block text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                            ATTENDANCE & LEAVE MANAGEMENT
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ \Illuminate\Support\Facades\URL::route('dashboard') }}"
                           class="px-6 py-3 rounded-xl text-white text-sm font-extrabold uppercase tracking-wider shadow-lg hover:scale-105 active:scale-95 transition-all duration-300 ease-out cursor-pointer" style="background:linear-gradient(to right,#1a2f6b,#1e5fa8)">
                            Dashboard →
                        </a>
                    @else
                        <a href="{{ \Illuminate\Support\Facades\URL::route('login') }}"
                           class="px-6 py-3 rounded-xl bg-white/90 text-slate-800 text-sm font-extrabold uppercase tracking-wider border border-slate-200 hover:scale-105 active:scale-95 hover:shadow-lg transition-all duration-300 ease-out cursor-pointer">
                            Login
                        </a>


                    @endauth
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <section class="relative z-10 max-w-7xl mx-auto px-6 lg:px-10 pt-16 md:pt-20 pb-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                {{-- Left hero --}}
                <div class="lg:col-span-7 text-center lg:text-left">

                    <div class="flex justify-center lg:justify-start">
                        <img src="{{ \Illuminate\Support\Facades\URL::asset('images/logo.png') }}" alt="Sistem Absensi & HRIS Digital" class="max-w-xs md:max-w-sm lg:max-w-md w-full h-auto object-contain" style="max-height:180px">
                    </div>

                    <p class="mt-8 text-sm md:text-base text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                       Sistem informasi manajemen absensi dan cuti berbasis web yang membantu proses pencatatan kehadiran, pengajuan cuti, persetujuan, serta pelaporan karyawan secara lebih efektif di lingkungan <strong class="text-slate-900">PT Defourd Sejahtera Bersama</strong>.
                    </p>

                    <div class="mt-10 mb-8 flex justify-center lg:justify-start">
                        <a href="{{ \Illuminate\Support\Facades\URL::route('login') }}"
                           class="inline-flex items-center justify-center px-8 py-4 rounded-2xl text-white text-base font-black uppercase tracking-wider shadow-2xl hover:scale-105 active:scale-95 hover:shadow-3xl hover:brightness-110 transition-all duration-300 ease-out cursor-pointer" style="background:linear-gradient(to right,#1a2f6b,#2da84a)">
                            Masuk Sekarang →
                        </a>
                    </div>

                    {{-- Mini stats --}}
                    <div class="mt-16 grid grid-cols-3 gap-4 max-w-xl mx-auto lg:mx-0">
                        <div class="soft-card rounded-2xl p-4 text-center border-t-4 border-[#1a2f6b]">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center mx-auto text-[#1a2f6b] mb-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-black text-[#1a2f6b]">QR Attendance</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Scan Absensi</p>
                        </div>
                        <div class="soft-card rounded-2xl p-4 text-center border-t-4 border-[#2da84a]">
                            <div class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center mx-auto text-[#2da84a] mb-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-black text-[#2da84a]">Leave Request</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Pengajuan Cuti</p>
                        </div>
                        <div class="soft-card rounded-2xl p-4 text-center border-t-4 border-[#1a2f6b]">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center mx-auto text-[#1a2f6b] mb-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-black text-[#1a2f6b]">HR Report</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Rekap Laporan</p>
                        </div>
                    </div>
                </div>

                {{-- Right visual dashboard --}}
                <div class="lg:col-span-5">
                    <div class="relative max-w-md mx-auto float-up">
                        <div class="absolute -inset-5 rounded-[2.5rem] blur-2xl" style="background:linear-gradient(to right,rgba(26,47,107,0.2),rgba(45,168,74,0.15))"></div>

                        <div class="relative glass rounded-[2rem] p-6 border border-slate-200">
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
                                <div>
                                    <p class="text-[10px] text-slate-500 font-extrabold uppercase tracking-widest">Dashboard Preview</p>
                                    <h3 class="text-xl font-extrabold text-slate-900">HRIS Overview</h3>
                                </div>
                                <div class="w-10 h-10 rounded-xl text-white flex items-center justify-center shadow-md" style="background:linear-gradient(135deg,#1a2f6b,#2da84a)">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="rounded-2xl text-white p-4 shadow-md" style="background:linear-gradient(135deg,#1a2f6b,#1e5fa8)">
                                    <p class="text-[10px] uppercase font-bold opacity-85 tracking-wider">Hadir Hari Ini</p>
                                    <h4 class="text-3xl font-black mt-1">{{ $hadirHariIniPersen }}%</h4>
                                </div>
                                <div class="rounded-2xl bg-white/80 p-4 border border-slate-200 shadow-sm">
                                    <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Cuti Aktif</p>
                                    <h4 class="text-3xl font-black mt-1 text-slate-900">{{ $cutiAktifCount }}</h4>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-white/80 p-5 border border-slate-200 shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700">Aktivitas Absensi</h4>
                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase bg-green-100 text-green-600">Live Status</span>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-xs mb-1.5 font-bold">
                                            <span class="text-slate-600">ABSENSI</span>
                                            <span class="font-black text-blue-600">{{ $absensiPersen }}%</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ $absensiPersen }}%; background:linear-gradient(to right,#1a2f6b,#1e5fa8)"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-xs mb-1.5 font-bold">
                                            <span class="text-slate-600">CUTI</span>
                                            <span class="font-black text-green-600">{{ $cutiPersen }}%</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ $cutiPersen }}%; background:linear-gradient(to right,#2da84a,#166534)"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-xs mb-1.5 font-bold">
                                            <span class="text-slate-600">LAPORAN</span>
                                            <span class="font-black text-blue-600">{{ $laporanPersen }}%</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ $laporanPersen }}%; background:linear-gradient(to right,#1e5fa8,#2da84a)"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div class="rounded-xl bg-white/80 border border-slate-200 p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center mx-auto text-[#1a2f6b]">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-[9px] mt-1.5 font-bold uppercase tracking-wider text-slate-600">ABSENSI</p>
                                </div>
                                <div class="rounded-xl bg-white/80 border border-slate-200 p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center mx-auto text-[#2da84a]">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-[9px] mt-1.5 font-bold uppercase tracking-wider text-slate-600">CUTI</p>
                                </div>
                                <div class="rounded-xl bg-white/80 border border-slate-200 p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center mx-auto text-yellow-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-[9px] mt-1.5 font-bold uppercase tracking-wider text-slate-600">LAPORAN</p>
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


</body>
</html>