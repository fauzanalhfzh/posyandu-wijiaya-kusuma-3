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

        $totalIbuUnik = DB::table('pemeriksaan_ibu')
            ->select('ibu_id')
            ->distinct()
            ->count();

        $pemeriksaanBulanIni = DB::table('pemeriksaan_ibu')
            ->whereYear('tanggal_pemeriksaan', $now->year)
            ->whereMonth('tanggal_pemeriksaan', $now->month)
            ->count();

        return [
            Stat::make('Pemeriksaan Tahun Ini', $totalPemeriksaanTahunIni)
                ->description('Total pemeriksaan ibu di tahun ' . $now->year)
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Jumlah Ibu Berbeda', $totalIbuUnik)
                ->description('Jumlah ibu berbeda yang diperiksa tahun ini')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Pemeriksaan Bulan Ini', $pemeriksaanBulanIni)
                ->description('Data bulan ' . $now->format('F'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
