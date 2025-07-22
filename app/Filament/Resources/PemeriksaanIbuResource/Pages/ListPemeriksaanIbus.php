<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Pages;

use App\Filament\Resources\PemeriksaanIbuResource;
use Filament\Actions;
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
        ];
    }
}
