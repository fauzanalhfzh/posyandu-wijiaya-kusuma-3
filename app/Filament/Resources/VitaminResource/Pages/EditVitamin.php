<?php

namespace App\Filament\Resources\VitaminResource\Pages;

use App\Filament\Resources\VitaminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVitamin extends EditRecord
{
    protected static string $resource = VitaminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
