<?php

namespace App\Filament\Resources\BidanResource\Pages;

use App\Filament\Resources\BidanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBidans extends ListRecords
{
    protected static string $resource = BidanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Bidan')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}
