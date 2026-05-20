<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', Carbon::now()->month);
        $tahun = (int) $request->input('tahun', Carbon::now()->year);

        $jamMasukSetting = Setting::where('key', 'jam_masuk')->value('value') ?? '08:00:00';

        $karyawan = User::where('role', 'karyawan')
            ->with(['attendances' => function ($query) use ($bulan, $tahun) {
                $query->whereMonth('attendance_date', $bulan)
                      ->whereYear('attendance_date', $tahun);
            }])
            ->get();

        return view('laporan.absensi.index', compact('karyawan', 'bulan', 'tahun', 'jamMasukSetting'));
    }

    public function export(Request $request)
    {
        $bulan = (int) $request->input('bulan', Carbon::now()->month);
        $tahun = (int) $request->input('tahun', Carbon::now()->year);

        $jamMasukSetting = Setting::where('key', 'jam_masuk')->value('value') ?? '08:00:00';

        $karyawan = User::where('role', 'karyawan')
            ->with(['attendances' => function ($query) use ($bulan, $tahun) {
                $query->whereMonth('attendance_date', $bulan)
                      ->whereYear('attendance_date', $tahun);
            }])
            ->get();

        $daysInMonth = Carbon::createFromDate($tahun, $bulan)->daysInMonth;
        $namaBulan   = Carbon::create()->month($bulan)->translatedFormat('F');

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Absensi');

        // Total columns: 1 (Nama) + daysInMonth + 2 (H, A)
        $totalCols    = 1 + $daysInMonth + 2;
        $lastColLetter = Coordinate::stringFromColumnIndex($totalCols);

        // Title row
        $sheet->mergeCells("A1:{$lastColLetter}1");
        $sheet->setCellValue('A1', "LAPORAN ABSENSI BULANAN - " . strtoupper($namaBulan) . " {$tahun}");
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E40AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(32);

        // Header row - Nama Karyawan
        $sheet->setCellValue('A2', 'Nama Karyawan');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF3B82F6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
        ]);

        // Header row - Days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $colIndex  = $day + 1;
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $date      = Carbon::createFromDate($tahun, $bulan, $day);
            $isWeekend = $date->isWeekend();

            $sheet->setCellValue("{$colLetter}2", $day);
            $bgColor = $isWeekend ? 'FFD1D5DB' : 'FF3B82F6';
            $sheet->getStyle("{$colLetter}2")->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
            ]);
            $sheet->getColumnDimension($colLetter)->setWidth(6);
        }

        // Header row - H dan A
        $colH = Coordinate::stringFromColumnIndex($daysInMonth + 2);
        $colA = Coordinate::stringFromColumnIndex($daysInMonth + 3);

        foreach ([[$colH, 'H', 'FF16A34A'], [$colA, 'A', 'FFDC2626']] as [$col, $label, $color]) {
            $sheet->setCellValue("{$col}2", $label);
            $sheet->getStyle("{$col}2")->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $color]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
            ]);
        }
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Data rows
        $row = 3;
        foreach ($karyawan as $user) {
            $hadirCount = 0;
            $alphaCount = 0;

            $sheet->setCellValue("A{$row}", $user->name);
            $sheet->getStyle("A{$row}")->applyFromArray([
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
            ]);

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $colIndex   = $day + 1;
                $colLetter  = Coordinate::stringFromColumnIndex($colIndex);
                $currentDate = Carbon::createFromDate($tahun, $bulan, $day);
                $attendance = $user->attendances->firstWhere('attendance_date', $currentDate->toDateString());
                $isWeekend  = $currentDate->isWeekend();

                if ($attendance) {
                    $checkIn     = Carbon::parse($attendance->check_in_time);
                    $jamMasuk    = Carbon::parse($jamMasukSetting);
                    $isTelat     = $checkIn->gt($jamMasuk);
                    $cellValue   = $checkIn->format('H:i');
                    $bgColor     = $isTelat ? 'FFFECACA' : 'FFD1FAE5';
                    $hadirCount++;
                } elseif ($isWeekend) {
                    $cellValue = 'L';
                    $bgColor   = 'FFF3F4F6';
                } else {
                    $cellValue = 'A';
                    $bgColor   = 'FFFFFFFF';
                    $alphaCount++;
                }

                $sheet->setCellValue("{$colLetter}{$row}", $cellValue);
                $sheet->getStyle("{$colLetter}{$row}")->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
                ]);
            }

            // Total H
            $sheet->setCellValue("{$colH}{$row}", $hadirCount);
            $sheet->getStyle("{$colH}{$row}")->applyFromArray([
                'font'      => ['bold' => true],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD1FAE5']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
            ]);

            // Total A
            $sheet->setCellValue("{$colA}{$row}", $alphaCount);
            $sheet->getStyle("{$colA}{$row}")->applyFromArray([
                'font'      => ['bold' => true],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFEE2E2']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
            ]);

            $row++;
        }

        // Auto-size nama column
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension($colH)->setWidth(8);
        $sheet->getColumnDimension($colA)->setWidth(8);

        $writer   = new Xlsx($spreadsheet);
        $filename = "Laporan_Absensi_{$namaBulan}_{$tahun}.xlsx";

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Cache-Control'       => 'max-age=0',
            ]
        );
    }
}