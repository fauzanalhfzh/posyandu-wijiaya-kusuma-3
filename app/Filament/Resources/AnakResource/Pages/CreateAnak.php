<?php

namespace App\Filament\Resources\AnakResource\Pages;

use App\Filament\Resources\AnakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnak extends CreateRecord
{
    protected static string $resource = AnakResource::class;

    protected function getRedirectUrl(): string
    {
        return AnakResource::getUrl('index');
    }
}
