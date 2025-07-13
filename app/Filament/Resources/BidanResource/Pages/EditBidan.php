<?php

namespace App\Filament\Resources\BidanResource\Pages;

use App\Filament\Resources\BidanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBidan extends EditRecord
{
    protected static string $resource = BidanResource::class;

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
