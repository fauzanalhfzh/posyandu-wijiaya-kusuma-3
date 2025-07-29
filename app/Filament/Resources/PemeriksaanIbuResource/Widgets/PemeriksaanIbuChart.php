<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemeriksaanIbuChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pemeriksaan Ibu per Bulan';

    protected function getData(): array
    {
        $year = Carbon::now()->year;

        // Ambil jumlah pemeriksaan ibu per bulan untuk tahun berjalan
        $data = DB::table('pemeriksaan_ibu')
            ->selectRaw('MONTH(tanggal_pemeriksaan) as month, COUNT(*) as total')
            ->whereYear('tanggal_pemeriksaan', $year)
            ->groupByRaw('MONTH(tanggal_pemeriksaan)')
            ->pluck('total', 'month');

        // Inisialisasi array jumlah per bulan
        $monthlyCounts = array_fill(1, 12, 0);

        foreach ($data as $month => $count) {
            $monthlyCounts[$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemeriksaan',
                    'data' => array_values($monthlyCounts),
                    'backgroundColor' => '#10b981', // hijau
                ],
            ],
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
