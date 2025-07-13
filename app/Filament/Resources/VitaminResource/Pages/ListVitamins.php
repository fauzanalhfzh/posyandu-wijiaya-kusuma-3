<?php

namespace App\Filament\Resources\VitaminResource\Pages;

use App\Filament\Resources\VitaminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVitamins extends ListRecords
{
    protected static string $resource = VitaminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
