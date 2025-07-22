<?php

namespace App\Filament\Resources\PemeriksaanAnakResource\Pages;

use App\Filament\Resources\PemeriksaanAnakResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPemeriksaanAnak extends ViewRecord
{
    protected static string $resource = PemeriksaanAnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
