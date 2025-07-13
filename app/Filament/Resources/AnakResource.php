<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnakResource\Pages;
use App\Filament\Resources\AnakResource\RelationManagers;
use App\Models\Anak;
use App\Models\Ibu;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Anak';

    protected static ?string $navigationGroup = 'Kelola Data';

    protected static ?string $label = "Kelola Data Anak";

    protected static ?string $slug = "kelola-data/anak";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ibu_id')
                    ->label('Nama Ibu')
                    ->columnSpan('full')
                    ->required()
                    ->options(Ibu::all()->pluck('nama_lengkap', 'id')),
                TextInput::make('nama_lengkap')
                    ->columnSpan('full')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tgl_lahir')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->required()
                    ->options([
                        'Pria' => 'pria',
                        'Wanita' => 'wanita',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ibu_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('tgl_lahir')
                    ->date()
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAnaks::route('/'),
            'create' => Pages\CreateAnak::route('/create'),
            'view' => Pages\ViewAnak::route('/{record}'),
            'edit' => Pages\EditAnak::route('/{record}/edit'),
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
