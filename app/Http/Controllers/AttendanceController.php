<?php

namespace App\Http\Controllers;
use function App\Helpers\calculateDistance;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input dasar — lokasi opsional jika GPS tidak tersedia
        $request->validate([
            'qr_token' => 'required|string',
            'location' => ['nullable', 'string', 'regex:/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/'],
        ], [
            'qr_token.required' => 'QR Code tidak boleh kosong.',
            'location.regex'    => 'Format lokasi tidak valid.',
        ]);

        $now    = Carbon::now();
        $today  = $now->toDateString();
        $userId = Auth::id();

        // 2. Validasi token QR Code
        $qrTokenKey = 'qr_token_' . $today;
        $validToken = Setting::where('key', $qrTokenKey)->value('value');

        if (!$validToken || $request->qr_token !== $validToken) {
            return Redirect::back()->with('error', 'QR Code tidak valid atau sudah kedaluwarsa. Minta admin untuk membuka halaman QR Code hari ini.');
        }

        // 3. Ambil pengaturan sistem
        $settings = Setting::all()->keyBy('key');

        $lokasiKantorLat = $settings['lokasi_kantor_lat']->value ?? null;
        $lokasiKantorLon = $settings['lokasi_kantor_lon']->value ?? null;
        $radiusAbsensi   = (float) ($settings['radius_absensi']->value ?? 100);

        // 4. Validasi jarak lokasi (hanya jika lokasi tersedia)
        $locationString = $request->location ?? '';
        if ($locationString && $lokasiKantorLat && $lokasiKantorLon) {
            [$latitude, $longitude] = array_map('floatval', explode(',', $locationString));

            $jarak = calculateDistance(
                $latitude,
                $longitude,
                (float) $lokasiKantorLat,
                (float) $lokasiKantorLon
            );

            if ($jarak !== null && $jarak > $radiusAbsensi) {
                return Redirect::back()->with(
                    'error',
                    'Anda berada di luar radius kantor. Jarak Anda ' . round($jarak) . ' meter (maks: ' . $radiusAbsensi . ' meter).'
                );
            }
        }

        // 5. Ambil pengaturan waktu
        $jamMasukSetting  = $settings['jam_masuk']->value  ?? '08:00:00';
        $jamPulangSetting = $settings['jam_pulang']->value ?? '17:00:00';

        $attendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        // 6. Logika absen masuk
        if (!$attendance) {
            $waktuMulaiAbsen = Carbon::parse($jamMasukSetting)->subMinutes(40);

            if ($now->isBefore($waktuMulaiAbsen)) {
                return Redirect::back()->with(
                    'error',
                    'Belum waktunya absen masuk. Anda bisa absen mulai jam ' . $waktuMulaiAbsen->format('H:i') . '.'
                );
            }

            if ($now->isAfter(Carbon::parse($jamPulangSetting))) {
                return Redirect::back()->with('error', 'Waktu absen masuk sudah terlewat (batas jam ' . Carbon::parse($jamPulangSetting)->format('H:i') . ').');
            }

            Attendance::create([
                'user_id'          => $userId,
                'attendance_date'  => $today,
                'check_in_time'    => $now->toTimeString(),
                'check_in_location'=> $locationString ?: 'Lokasi tidak tersedia',
            ]);

            return Redirect::back()->with('status', 'Absen masuk berhasil dicatat pukul ' . $now->format('H:i') . '.');
        }

        // 8. Logika absen pulang
        if ($attendance->check_out_time) {
            return Redirect::back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        if ($now->isBefore(Carbon::parse($jamPulangSetting))) {
            return Redirect::back()->with(
                'error',
                'Belum waktunya absen pulang. Waktu pulang adalah jam ' . Carbon::parse($jamPulangSetting)->format('H:i')
            );
        }

        $attendance->update([
            'check_out_time' => $now->toTimeString(),
            'check_out_location' => $request->location,
        ]);

        return Redirect::back()->with('status', 'Absen pulang berhasil dicatat.');
    }
}