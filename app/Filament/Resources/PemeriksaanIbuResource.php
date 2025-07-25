<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemeriksaanIbuResource\Pages;
use App\Filament\Resources\PemeriksaanIbuResource\RelationManagers;
use App\Models\Bidan;
use App\Models\Ibu;
use App\Models\PemeriksaanIbu;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemeriksaanIbuResource extends Resource
{
    protected static ?string $model = PemeriksaanIbu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pemeriksaan Ibu';

    protected static ?string $navigationGroup = 'KMS (Kartu Menuju Sehat)';

    protected static ?string $label = "Kelola Data Pemeriksaan Ibu";

    protected static ?string $slug = "kelola-data/pemeriksaan-ibu";

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
                    ->required()
                    ->options(Ibu::all()->pluck('nama_lengkap', 'id')),
                Select::make('bidan_id')
                    ->label('Nama Bidan')
                    ->required()
                    ->options(Bidan::all()->pluck('nama_lengkap', 'id')),
                DatePicker::make('tanggal_pemeriksaan')
                    ->required(),
                TextInput::make('keluhan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('berat_badan')
                    ->label('Berat Badan (kg)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('tinggi_badan')
                    ->label('Tinggi Badan (cm)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('tekanan_darah')
                    ->required()
                    ->maxLength(255),
                TextInput::make('usia_kehamilan')
                    ->label('Usia Kehamilan (minggu)')
                    ->required()
                    ->numeric(),
                TextInput::make('tinggi_fundus')
                    ->required()
                    ->numeric(),
                TextInput::make('letak_janin')
                    ->required()
                    ->maxLength(255),
                TextInput::make('denyut_jantung_janin')
                    ->required()
                    ->maxLength(255),
                TextInput::make('keterangan')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_pemeriksaan')
                    ->searchable()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ibu.nama_lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bidan.nama_lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keluhan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->suffix(' kg')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->suffix(' cm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tekanan_darah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('usia_kehamilan')
                    ->suffix(' minggu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tinggi_fundus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('letak_janin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('denyut_jantung_janin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPemeriksaanIbus::route('/'),
            'create' => Pages\CreatePemeriksaanIbu::route('/create'),
            'view' => Pages\ViewPemeriksaanIbu::route('/{record}'),
            'edit' => Pages\EditPemeriksaanIbu::route('/{record}/edit'),
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
