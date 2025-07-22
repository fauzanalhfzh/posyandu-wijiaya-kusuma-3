<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Pages;

use App\Filament\Resources\PemeriksaanIbuResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPemeriksaanIbu extends ViewRecord
{
    protected static string $resource = PemeriksaanIbuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
