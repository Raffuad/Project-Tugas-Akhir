<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan.
     */
    public function index()
    {
        // Ambil semua data settings dan ubah menjadi format yang mudah diakses di view
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Menyimpan atau memperbarui data pengaturan.
     */
    public function update(Request $request)
    {
        // 1. Validasi input dasar
        $request->validate([
            'jam_masuk' => ['required', 'string', 'regex:/^\d{2}:\d{2}$/'],
            'jam_pulang' => ['required', 'string', 'regex:/^\d{2}:\d{2}$/'],
            'radius_absensi' => ['required', 'numeric', 'min:1'],
            'lokasi_kantor_lat' => ['required', 'string'],
            'lokasi_kantor_lon' => ['required', 'string'],
        ], [
            'jam_masuk.required' => 'Jam masuk harus diisi.',
            'jam_masuk.regex' => 'Format jam masuk harus HH:MM (contoh: 08:00).',
            'jam_pulang.required' => 'Jam pulang harus diisi.',
            'jam_pulang.regex' => 'Format jam pulang harus HH:MM (contoh: 17:00).',
            'radius_absensi.required' => 'Radius absensi harus diisi.',
            'radius_absensi.numeric' => 'Radius absensi harus berupa angka.',
            'radius_absensi.min' => 'Radius absensi minimal 1 meter.',
            'lokasi_kantor_lat.required' => 'Latitude kantor harus diisi.',
            'lokasi_kantor_lon.required' => 'Longitude kantor harus diisi.',
        ]);

        $latInput = trim($request->input('lokasi_kantor_lat'));
        $lonInput = trim($request->input('lokasi_kantor_lon'));

        // Ekstrak angka desimal (bisa menggunakan dot atau koma sebagai separator desimal)
        preg_match_all('/-?\d+(?:[\.,]\d+)?/', $latInput, $latMatches);
        preg_match_all('/-?\d+(?:[\.,]\d+)?/', $lonInput, $lonMatches);

        // Latitude: ambil angka pertama yang ditemukan
        $latValue = null;
        if (!empty($latMatches[0])) {
            $latValue = str_replace(',', '.', $latMatches[0][0]);
        }

        // Longitude: jika diinput data koordinat lengkap (lat, lon), ambil angka kedua.
        // Jika tidak, ambil angka pertama.
        $lonValue = null;
        if (!empty($lonMatches[0])) {
            $lonValue = count($lonMatches[0]) >= 2 
                ? str_replace(',', '.', $lonMatches[0][1])
                : str_replace(',', '.', $lonMatches[0][0]);
        }

        // Pastikan hasil ekstraksi valid sebagai angka/float
        if (!$latValue || !is_numeric($latValue) || !$lonValue || !is_numeric($lonValue)) {
            return Redirect::back()->withInput()->withErrors([
                'lokasi_kantor_lat' => 'Format Latitude atau Longitude tidak valid. Pastikan memasukkan koordinat numerik yang benar.',
            ]);
        }

        $settings = [
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_pulang' => $request->input('jam_pulang'),
            'radius_absensi' => $request->input('radius_absensi'),
            'lokasi_kantor_lat' => $latValue,
            'lokasi_kantor_lon' => $lonValue,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return Redirect::route('admin.settings.index')->with('status', 'Pengaturan berhasil diperbarui.');
    }
}