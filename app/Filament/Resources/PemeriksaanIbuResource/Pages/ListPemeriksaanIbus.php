<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Pages;

use App\Filament\Resources\PemeriksaanIbuResource;
use Filament\Actions;
use Filament\Actions\Action;
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
            Action::make('Print Laporan')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-document-text')
                ->url(route('laporan.pemeriksaan-ibu'))
                ->openUrlInNewTab()
                ->color('success'),
        ];
    }
}
