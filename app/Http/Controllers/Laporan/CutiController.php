<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $bulan  = (int) $request->input('bulan', Carbon::now()->month);
        $tahun  = (int) $request->input('tahun', Carbon::now()->year);
        $status = $request->input('status', 'all');

        $query = Leave::with(['user', 'approver'])
            ->whereMonth('start_date', $bulan)
            ->whereYear('start_date', $tahun);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $leaves = $query->orderBy('start_date', 'desc')->get();

        // Summary stats
        $totalDiajukan  = $leaves->count();
        $totalDisetujui = $leaves->where('status', 'approved')->count();
        $totalDitolak   = $leaves->where('status', 'rejected')->count();
        $totalPending   = $leaves->where('status', 'pending')->count();

        return view('laporan.cuti.index', compact(
            'leaves', 'bulan', 'tahun', 'status',
            'totalDiajukan', 'totalDisetujui', 'totalDitolak', 'totalPending'
        ));
    }

    public function export(Request $request)
    {
        $bulan  = (int) $request->input('bulan', Carbon::now()->month);
        $tahun  = (int) $request->input('tahun', Carbon::now()->year);
        $status = $request->input('status', 'all');

        $query = Leave::with(['user', 'approver'])
            ->whereMonth('start_date', $bulan)
            ->whereYear('start_date', $tahun);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $leaves = $query->orderBy('start_date', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Cuti');

        // Title row
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', "LAPORAN CUTI - " . strtoupper($namaBulan) . " {$tahun}");
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E40AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(32);

        // Header row
        $headers = [
            'No', 'Nama Karyawan', 'Jenis Cuti', 'Tanggal Mulai',
            'Tanggal Selesai', 'Total Hari', 'Alasan', 'Status',
            'Diproses Oleh', 'Catatan Atasan',
        ];
        foreach ($headers as $i => $header) {
            $col = Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue("{$col}2", $header);
        }
        $sheet->getStyle('A2:J2')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF3B82F6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        // Data rows
        $row = 3;
        foreach ($leaves as $i => $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate   = Carbon::parse($leave->end_date);
            $totalHari = $startDate->diffInDays($endDate) + 1;

            $statusLabel = match ($leave->status) {
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'pending'  => 'Menunggu',
                default    => $leave->status,
            };

            $jenisCuti = match ($leave->type) {
                'cuti_tahunan' => 'Cuti Tahunan',
                'cuti_sakit'   => 'Cuti Sakit',
                'izin'         => 'Izin',
                default        => ucfirst(str_replace('_', ' ', $leave->type)),
            };

            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $leave->user->name ?? '-');
            $sheet->setCellValue("C{$row}", $jenisCuti);
            $sheet->setCellValue("D{$row}", $startDate->format('d/m/Y'));
            $sheet->setCellValue("E{$row}", $endDate->format('d/m/Y'));
            $sheet->setCellValue("F{$row}", $totalHari);
            $sheet->setCellValue("G{$row}", $leave->reason ?? '-');
            $sheet->setCellValue("H{$row}", $statusLabel);
            $sheet->setCellValue("I{$row}", $leave->approver->name ?? '-');
            $sheet->setCellValue("J{$row}", $leave->approver_notes ?? '-');

            $bgColor = match ($leave->status) {
                'approved' => 'FFD1FAE5',
                'rejected' => 'FFFEE2E2',
                'pending'  => 'FFFEF3C7',
                default    => 'FFFFFFFF',
            };

            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE5E7EB']]],
            ]);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        // Auto-size columns
        foreach (range(1, 10) as $colIndex) {
            $col = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer   = new Xlsx($spreadsheet);
        $filename = "Laporan_Cuti_{$namaBulan}_{$tahun}.xlsx";

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
