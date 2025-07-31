<?php

namespace App\Filament\Resources\PemeriksaanIbuResource\Pages;

use App\Filament\Resources\PemeriksaanIbuResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPemeriksaanIbu extends ViewRecord
{
    protected static string $resource = PemeriksaanIbuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('Cetak PDF')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pemeriksaan-ibu.cetak', $this->record->id))
                ->openUrlInNewTab()
                ->color('primary'),
        ];
    }
}
