<?php

namespace App\Filament\Resources\IbuResource\Pages;

use App\Filament\Resources\IbuResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIbu extends ViewRecord
{
    protected static string $resource = IbuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
