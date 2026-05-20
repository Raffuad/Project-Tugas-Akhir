<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Cuti & Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 font-medium">Total Diajukan</p>
                    <p class="text-3xl font-extrabold text-blue-600">{{ $totalDiajukan }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 font-medium">Disetujui</p>
                    <p class="text-3xl font-extrabold text-green-600">{{ $totalDisetujui }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 font-medium">Ditolak</p>
                    <p class="text-3xl font-extrabold text-red-600">{{ $totalDitolak }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 font-medium">Menunggu</p>
                    <p class="text-3xl font-extrabold text-yellow-600">{{ $totalPending }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Filter & Export Form --}}
                    <form method="GET" action="{{ route('laporan.cuti.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                            <select name="bulan" id="bulan" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" name="tahun" id="tahun" value="{{ $tahun }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="all"      {{ $status === 'all'      ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending"  {{ $status === 'pending'  ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <x-primary-button type="submit">Filter</x-primary-button>

                        {{-- Export Excel Button --}}
                        <a href="{{ route('laporan.cuti.export', ['bulan' => $bulan, 'tahun' => $tahun, 'status' => $status]) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Export Excel
                        </a>
                    </form>

                    {{-- Legend --}}
                    <div class="flex flex-wrap gap-3 mb-4 text-xs">
                        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full bg-yellow-200 border border-yellow-400"></span> Menunggu</span>
                        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full bg-green-200 border border-green-400"></span> Disetujui</span>
                        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full bg-red-200 border border-red-400"></span> Ditolak</span>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Mulai</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Selesai</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diproses Oleh</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($leaves as $i => $leave)
                                    @php
                                        $startDate = \Carbon\Carbon::parse($leave->start_date);
                                        $endDate   = \Carbon\Carbon::parse($leave->end_date);
                                        $totalHari = $startDate->diffInDays($endDate) + 1;
                                        $rowBg = match($leave->status) {
                                            'approved' => 'bg-green-50',
                                            'rejected' => 'bg-red-50',
                                            'pending'  => 'bg-yellow-50',
                                            default    => '',
                                        };
                                        $jenisCuti = match($leave->type) {
                                            'cuti_tahunan' => 'Cuti Tahunan',
                                            'cuti_sakit'   => 'Cuti Sakit',
                                            'izin'         => 'Izin',
                                            default        => ucfirst(str_replace('_', ' ', $leave->type)),
                                        };
                                    @endphp
                                    <tr class="{{ $rowBg }}">
                                        <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $leave->user->name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $jenisCuti }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $startDate->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $endDate->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-center font-semibold text-gray-700">{{ $totalHari }}</td>
                                        <td class="px-4 py-3 text-gray-700 max-w-xs truncate" title="{{ $leave->reason }}">{{ $leave->reason ?? '-' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if ($leave->status === 'approved')
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Disetujui</span>
                                            @elseif ($leave->status === 'rejected')
                                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Ditolak</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ $leave->approver->name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-700 max-w-xs truncate" title="{{ $leave->approver_notes }}">{{ $leave->approver_notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-4 py-8 text-center text-gray-400">
                                            Tidak ada data cuti untuk periode yang dipilih.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
