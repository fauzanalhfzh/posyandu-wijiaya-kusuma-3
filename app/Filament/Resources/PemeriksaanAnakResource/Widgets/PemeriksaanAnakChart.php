<?php

namespace App\Filament\Resources\PemeriksaanAnakResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemeriksaanAnakChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pemeriksaan Anak per Bulan';

    protected function getData(): array
    {
        $year = Carbon::now()->year;

        // Hitung jumlah pemeriksaan anak per bulan di tahun berjalan
        $data = DB::table('pemeriksaan_anak')
            ->selectRaw('MONTH(tanggal_pemeriksaan) as month, COUNT(*) as total')
            ->whereYear('tanggal_pemeriksaan', $year)
            ->groupByRaw('MONTH(tanggal_pemeriksaan)')
            ->pluck('total', 'month');

        // Buat array default 12 bulan, isi default 0
        $monthlyCounts = array_fill(1, 12, 0);

        foreach ($data as $month => $count) {
            $monthlyCounts[$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemeriksaan',
                    'data' => array_values($monthlyCounts),
                    'backgroundColor' => '#3b82f6', // biru
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
                'Dec',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
