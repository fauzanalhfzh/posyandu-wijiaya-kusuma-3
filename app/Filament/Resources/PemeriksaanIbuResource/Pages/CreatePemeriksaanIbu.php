<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Pages;

use App\Filament\Resources\PemeriksaanIbuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePemeriksaanIbu extends CreateRecord
{
    protected static string $resource = PemeriksaanIbuResource::class;

    protected function getRedirectUrl(): string
    {
        return PemeriksaanIbuResource::getUrl('index');
    }
}
