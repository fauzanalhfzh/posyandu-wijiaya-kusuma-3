<?php

namespace App\Filament\Resources\IbuResource\Pages;

use App\Filament\Resources\IbuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIbu extends CreateRecord
{
    protected static string $resource = IbuResource::class;

    protected function getRedirectUrl(): string
    {
        return IbuResource::getUrl('index');
    }
}
