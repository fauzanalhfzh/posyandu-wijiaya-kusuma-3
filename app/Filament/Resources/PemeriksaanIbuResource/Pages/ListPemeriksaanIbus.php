<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Pages;

use App\Filament\Resources\PemeriksaanIbuResource;
use App\Models\Ibu;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListPemeriksaanIbus extends ListRecords
{
    protected static string $resource = PemeriksaanIbuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Pemeriksaan Ibu')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
            Action::make('Print Laporan Bulan Ini')
                ->label('Cetak Laporan Bulan Ini')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->form([
                    Select::make('bulan')
                        ->label('Pilih Bulan')
                        ->options([
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember',
                        ])
                        ->default(now()->format('m')) // Default ke bulan saat ini
                        ->required(),

                    Select::make('tahun')
                        ->label('Pilih Tahun')
                        ->options([
                            now()->format('Y') => now()->format('Y'),
                        ])
                        ->default(now()->format('Y')) // Default ke tahun saat ini
                        ->required(),
                ])
                ->action(function ($form) {
                    // Mengambil bulan dan tahun yang dipilih dari form
                    $bulan = $form->getState()['bulan'];
                    $tahun = $form->getState()['tahun'];

                    // Log bulan dan tahun yang dipilih untuk debugging
                    \Log::info('Bulan dan Tahun yang dipilih untuk laporan:', ['bulan' => $bulan, 'tahun' => $tahun]);

                    // Redirect ke route laporan dengan bulan dan tahun yang dipilih
                    return redirect()->route('laporan.pemeriksaan-ibu', [
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ]);
                })
                ->openUrlInNewTab(),
        ];
    }
}
