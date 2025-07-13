<?php

namespace App\Filament\Resources\BidanResource\Pages;

use App\Filament\Resources\BidanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBidan extends ViewRecord
{
    protected static string $resource = BidanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
