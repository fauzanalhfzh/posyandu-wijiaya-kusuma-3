<?php

namespace App\Filament\Resources\PemeriksaanAnakResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class PemeriksaanAnakStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $now = Carbon::now();

        $totalPemeriksaanTahunIni = DB::table('pemeriksaan_anak')
            ->whereYear('tanggal_pemeriksaan', $now->year)
            ->count();

        $totalAnakUnik = DB::table('pemeriksaan_anak')
            ->select('anak_id')
            ->distinct()
            ->count();

        $pemeriksaanBulanIni = DB::table('pemeriksaan_anak')
            ->whereYear('tanggal_pemeriksaan', $now->year)
            ->whereMonth('tanggal_pemeriksaan', $now->month)
            ->count();

        return [
            Stat::make('Pemeriksaan Tahun Ini', $totalPemeriksaanTahunIni)
                ->description('Total pemeriksaan anak di tahun ' . $now->year)
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Anak Unik Diperiksa', $totalAnakUnik)
                ->description('Jumlah anak berbeda yang diperiksa')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Pemeriksaan Bulan Ini', $pemeriksaanBulanIni)
                ->description('Data bulan ' . $now->format('F'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
