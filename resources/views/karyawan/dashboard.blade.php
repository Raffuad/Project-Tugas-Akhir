<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        {{-- KOTAK ABSENSI UTAMA --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">
                    Selamat datang, {{ Auth::user()->name }}!
                </h3>

                {{-- Notifikasi Absensi dihandle menggunakan SweetAlert2 --}}

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <div class="text-center">
                        <p class="text-lg font-semibold">Absensi Hari Ini: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                        <p id="clock" class="text-4xl font-bold my-2"></p>
                        
                        {{-- Status Absensi --}}
                        @if ($todayAttendance && $todayAttendance->check_out_time)
                            <p class="text-blue-600 font-semibold">Anda sudah menyelesaikan absensi hari ini.</p>
                            <p class="text-sm">Masuk: {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }} | Pulang: {{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i') }}</p>
                        @elseif ($todayAttendance)
                            <p class="text-green-600 font-semibold">Anda sudah absen masuk pada jam {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}</p>
                        @endif

                        {{-- Tombol Aksi & Form --}}
                        @if (!$todayAttendance || !$todayAttendance->check_out_time)
                            {{-- Status bar untuk feedback real-time --}}
                            <div id="scan-status" class="hidden my-3 px-4 py-3 rounded-lg text-sm font-medium"></div>

                            {{-- Loading overlay --}}
                            <div id="loading-overlay" class="hidden items-center justify-center my-4 gap-2 text-indigo-600">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                                <span id="loading-text">Memproses...</span>
                            </div>

                            <div id="scanner-container" class="w-full max-w-sm mx-auto my-4 text-center" style="display: none;">
                                <div id="qr-reader" class="border-2 border-dashed rounded-lg p-2"></div>
                                <button type="button" id="close-scanner-button" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Tutup Kamera
                                </button>
                            </div>
    
                            <form id="attendance-form" method="POST" action="{{ route('karyawan.attendance.store') }}" class="hidden">
                                @csrf
                                <input type="hidden" name="location" id="location">
                                <input type="hidden" name="qr_token" id="qr_token">
                            </form>

                            <x-primary-button id="scan-button" class="mt-4">
                                <x-heroicon-s-qr-code class="w-5 h-5 mr-2" />
                                {{ !$todayAttendance ? 'Scan QR Absen Masuk' : 'Scan QR Absen Pulang' }}
                            </x-primary-button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel Informasi Panduan --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg border-b pb-3 mb-4">Panduan Penggunaan Sistem</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                        
                        <div class="space-y-2 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <x-heroicon-o-qr-code class="w-6 h-6 mr-2 text-indigo-600"/>
                                <h4 class="font-bold">Absensi Harian</h4>
                            </div>
                            <p class="text-gray-600">
                                Untuk melakukan absensi masuk atau pulang, klik tombol **"Scan QR"** di atas dan arahkan kamera Anda ke QR Code yang disediakan. Pastikan izin lokasi dan kamera aktif.
                            </p>
                        </div>

                        <div class="space-y-2 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <x-heroicon-o-clock class="w-6 h-6 mr-2 text-indigo-600"/>
                                <h4 class="font-bold">Pengajuan Lembur</h4>
                            </div>
                            <p class="text-gray-600">
                                Gunakan menu **"Lembur"** di sidebar untuk mengajukan jam kerja tambahan. Anda dapat melihat riwayat dan status persetujuan dari semua pengajuan lembur Anda di halaman tersebut.
                            </p>
                        </div>

                        <div class="space-y-2 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="w-6 h-6 mr-2 text-indigo-600"/>
                                <h4 class="font-bold">Pengajuan Cuti & Izin</h4>
                            </div>
                            <p class="text-gray-600">
                                Gunakan menu **"Cuti & Izin"** untuk mengajukan permohonan tidak masuk kerja. Untuk izin sakit, jangan lupa untuk mengunggah dokumen bukti seperti surat keterangan dokter.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ── JAM ──────────────────────────────────────────────
            const clockElement = document.getElementById('clock');
            function updateClock() {
                const now = new Date();
                clockElement.textContent = [
                    String(now.getHours()).padStart(2,'0'),
                    String(now.getMinutes()).padStart(2,'0'),
                    String(now.getSeconds()).padStart(2,'0')
                ].join(':');
            }
            setInterval(updateClock, 1000);
            updateClock();

            // ── SWEETALERT NOTIFICATIONS ─────────────────────────
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: "{!! addslashes(session('status')) !!}",
                    confirmButtonColor: '#2da84a'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{!! addslashes(session('error')) !!}",
                    confirmButtonColor: '#1a2f6b'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: `<ul style="text-align: left; list-style-type: disc; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{!! addslashes($error) !!}</li>
                        @endforeach
                    </ul>`,
                    confirmButtonColor: '#1a2f6b'
                });
            @endif

            // ── HELPER: tampilkan status di halaman (bukan alert) ─
            const statusDiv    = document.getElementById('scan-status');
            const loadingDiv   = document.getElementById('loading-overlay');
            const loadingText  = document.getElementById('loading-text');

            function showStatus(msg, type = 'error') {
                if (!statusDiv) return;
                statusDiv.className = 'my-3 px-4 py-3 rounded-lg text-sm font-medium ' + (
                    type === 'success'
                        ? 'bg-green-100 text-green-800'
                        : type === 'info'
                            ? 'bg-blue-100 text-blue-800'
                            : 'bg-red-100 text-red-800'
                );
                statusDiv.textContent = msg;
                statusDiv.classList.remove('hidden');
            }

            function hideStatus() {
                statusDiv?.classList.add('hidden');
            }

            function showLoading(msg = 'Memproses...') {
                if (!loadingDiv) return;
                loadingText.textContent = msg;
                loadingDiv.classList.remove('hidden');
                loadingDiv.classList.add('flex');
            }

            function hideLoading() {
                loadingDiv?.classList.add('hidden');
                loadingDiv?.classList.remove('flex');
            }

            // ── QR SCANNER ────────────────────────────────────────
            const scanButton        = document.getElementById('scan-button');
            const scannerContainer  = document.getElementById('scanner-container');
            const closeScannerButton= document.getElementById('close-scanner-button');
            let html5QrCode;

            function stopScanner() {
                if (html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop()
                        .then(() => {
                            scannerContainer.style.display = 'none';
                            if (scanButton) scanButton.style.display = 'inline-flex';
                        })
                        .catch(err => console.error("Gagal menghentikan kamera:", err));
                } else {
                    scannerContainer.style.display = 'none';
                    if (scanButton) scanButton.style.display = 'inline-flex';
                }
            }

            if (scanButton) {
                scanButton.addEventListener('click', function () {
                    hideStatus();

                    if (typeof Html5Qrcode === 'undefined') {
                        showStatus('Library scanner belum termuat. Periksa koneksi internet Anda, lalu muat ulang halaman.');
                        return;
                    }

                    scannerContainer.style.display = 'block';
                    this.style.display = 'none';

                    if (!html5QrCode) {
                        html5QrCode = new Html5Qrcode("qr-reader");
                    }

                    html5QrCode.start(
                        { facingMode: "environment" },
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        onScanSuccess,
                        () => {} // abaikan error per-frame
                    ).catch(err => {
                        console.error("Gagal memulai kamera:", err);
                        showStatus('Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan di browser Anda.');
                        stopScanner();
                    });
                });
            }

            if (closeScannerButton) {
                closeScannerButton.addEventListener('click', () => {
                    stopScanner();
                    hideStatus();
                    hideLoading();
                });
            }

            // ── SETELAH QR BERHASIL DISCAN ────────────────────────
            function onScanSuccess(decodedText) {
                stopScanner();
                document.getElementById('qr_token').value = decodedText;

                // Coba dapatkan GPS; jika gagal/tidak ada, tetap submit tanpa lokasi
                if (navigator.geolocation) {
                    showLoading('Mendeteksi lokasi GPS...');
                    
                    let timeLeft = 3;
                    showStatus(`QR berhasil dipindai. Mendeteksi lokasi GPS (${timeLeft} detik)...`, 'info');
                    
                    const countdownInterval = setInterval(() => {
                        timeLeft--;
                        if (timeLeft >= 0) {
                            showStatus(`QR berhasil dipindai. Mendeteksi lokasi GPS (${timeLeft} detik)...`, 'info');
                        } else {
                            clearInterval(countdownInterval);
                        }
                    }, 1000);

                    navigator.geolocation.getCurrentPosition(
                        position => {
                            clearInterval(countdownInterval);
                            const loc = `${position.coords.latitude},${position.coords.longitude}`;
                            document.getElementById('location').value = loc;
                            showLoading('Menyimpan absensi...');
                            document.getElementById('attendance-form').submit();
                        },
                        error => {
                            clearInterval(countdownInterval);
                            // GPS gagal — tetap submit, lokasi akan kosong
                            console.warn("GPS gagal:", error.message);
                            let info = 'GPS tidak terdeteksi. Absensi diproses tanpa data lokasi.';
                            if (error.code === 1) info = 'Izin GPS ditolak. Absensi diproses tanpa data lokasi.';
                            showStatus(info, 'info');
                            showLoading('Menyimpan absensi...');
                            document.getElementById('location').value = '';
                            document.getElementById('attendance-form').submit();
                        },
                        { enableHighAccuracy: false, timeout: 3000, maximumAge: 60000 }
                    );
                } else {
                    // Browser tidak support geolocation — tetap submit
                    showLoading('Menyimpan absensi...');
                    document.getElementById('location').value = '';
                    document.getElementById('attendance-form').submit();
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

