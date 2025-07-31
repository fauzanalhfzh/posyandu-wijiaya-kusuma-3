<?php

namespace App\Filament\Resources\PemeriksaanAnakResource\Pages;

use App\Filament\Resources\PemeriksaanAnakResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPemeriksaanAnak extends ViewRecord
{
    protected static string $resource = PemeriksaanAnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('Cetak PDF')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pemeriksaan-anak.cetak', $this->record->id))
                ->openUrlInNewTab()
                ->color('primary'),
        ];
    }
}
