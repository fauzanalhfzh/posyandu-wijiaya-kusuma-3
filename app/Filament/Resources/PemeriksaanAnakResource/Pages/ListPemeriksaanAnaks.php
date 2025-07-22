<?php

namespace App\Filament\Resources\PemeriksaanAnakResource\Pages;

use App\Filament\Resources\PemeriksaanAnakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemeriksaanAnaks extends ListRecords
{
    protected static string $resource = PemeriksaanAnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Pemeriksaan Anak')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}
