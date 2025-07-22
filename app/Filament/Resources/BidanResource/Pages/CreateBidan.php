<?php

namespace App\Filament\Resources\BidanResource\Pages;

use App\Filament\Resources\BidanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBidan extends CreateRecord
{
    protected static string $resource = BidanResource::class;

    protected function getRedirectUrl(): string
    {
        return BidanResource::getUrl('index');
    }
}
