<?php

namespace App\Filament\Resources\VitaminResource\Pages;

use App\Filament\Resources\VitaminResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVitamin extends ViewRecord
{
    protected static string $resource = VitaminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
