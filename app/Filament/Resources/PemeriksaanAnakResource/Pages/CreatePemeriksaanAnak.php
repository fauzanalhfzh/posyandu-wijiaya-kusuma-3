<?php

namespace App\Filament\Resources\PemeriksaanAnakResource\Pages;

use App\Filament\Resources\PemeriksaanAnakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePemeriksaanAnak extends CreateRecord
{
    protected static string $resource = PemeriksaanAnakResource::class;

    protected function getRedirectUrl(): string
    {
        return PemeriksaanAnakResource::getUrl('index');
    }
}
