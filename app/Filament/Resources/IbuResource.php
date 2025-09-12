<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IbuResource\Pages;
use App\Filament\Resources\IbuResource\RelationManagers;
use App\Models\Ibu;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IbuResource extends Resource
{
    protected static ?string $model = Ibu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = -3;

    protected static ?string $navigationGroup = 'Kelola Data';

    protected static ?string $label = "Kelola Data Ibu";

    protected static ?string $slug = "kelola-data/ibu";

    public static function getNavigationLabel(): string
    {
        return 'Ibu';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tgl_lahir')
                    ->required(),
                TextInput::make('tinggi_badan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('berat_badan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('tgl_lahir')
                    ->searchable(),
                TextColumn::make('tinggi_badan')
                    ->searchable(),
                TextColumn::make('berat_badan')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('cetak')
                    ->label('Cetak KMS Ibu') // Action label
                    ->icon('heroicon-o-printer') // Icon for the action
                    ->url(fn($record) => route('cetak.pemeriksaan-ibu', $record->id)) // URL to the PDF generation route
                    ->openUrlInNewTab() // Open the PDF in a new tab
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIbus::route('/'),
            'create' => Pages\CreateIbu::route('/create'),
            'view' => Pages\ViewIbu::route('/{record}'),
            'edit' => Pages\EditIbu::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
