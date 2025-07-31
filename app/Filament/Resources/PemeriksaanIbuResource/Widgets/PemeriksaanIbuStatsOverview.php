<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemeriksaanIbuStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $now = Carbon::now();

        $totalPemeriksaanTahunIni = DB::table('pemeriksaan_ibu')
            ->whereYear('tanggal_pemeriksaan', $now->year)
            ->count();

        $pemeriksaanBulanIni = DB::table('pemeriksaan_ibu')
            ->whereYear('tanggal_pemeriksaan', $now->year)
            ->whereMonth('tanggal_pemeriksaan', $now->month)
            ->count();

        // Ambil jumlah pemeriksaan per bulan
        $dataPerBulan = DB::table('pemeriksaan_ibu')
            ->selectRaw('MONTH(tanggal_pemeriksaan) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_pemeriksaan', $now->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan');

        // Buat array 12 bulan default 0
        $chartTahunIni = collect(range(1, 12))->map(function ($bulan) use ($dataPerBulan) {
            return $dataPerBulan[$bulan] ?? 0;
        })->toArray();

        return [
            Stat::make('Pemeriksaan Tahun Ini', $totalPemeriksaanTahunIni)
                ->description('Total pemeriksaan ibu di tahun ' . $now->year)
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($chartTahunIni)
                ->color('success'),

            Stat::make('Pemeriksaan Bulan Ini', $pemeriksaanBulanIni)
                ->description('Data bulan ' . $now->format('F'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart([$pemeriksaanBulanIni]) // Bisa juga dihilangkan
                ->color('primary'),
        ];
    }
}
