<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemeriksaanIbuResource\Pages;
use App\Filament\Resources\PemeriksaanIbuResource\RelationManagers;
use App\Models\Bidan;
use App\Models\Ibu;
use App\Models\PemeriksaanIbu;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
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
                Select::make('bidan_id')
                    ->label('Nama Bidan')
                    ->required()
                    ->options(Bidan::all()->pluck('nama_lengkap', 'id')),
                DatePicker::make('tanggal_pemeriksaan')
                    ->label('Tanggal Pemeriksaan')
                    ->required()
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        logger()->info('State tanggal_pemeriksaan:', ['state' => $state, 'ibu_id' => $get('ibu_id')]);

                        $ibu = Ibu::find($get('ibu_id'));

                        if ($ibu) {
                            $tglLahir = Carbon::parse($ibu->tgl_lahir); // Get the birthdate of the mother
                            $tanggalPemeriksaan = Carbon::parse($state); // Get the exam date

                            $usiaIbu = $tglLahir->diffInYears($tanggalPemeriksaan); // Calculate the age in years

                            // Set usia_ibu field automatically
                            $set('usia_ibu', $usiaIbu);
                        }
                    }),
                Select::make('ibu_id')
                    ->label('Nama Ibu')
                    ->required()
                    ->options(Ibu::all()->pluck('nama_lengkap', 'id'))
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        logger()->info('State ibu_id:', ['state' => $state, 'tanggal_pemeriksaan' => $get('tanggal_pemeriksaan'), 'ibu' => Ibu::find($state)]);

                        $ibu = Ibu::find($state);

                        if ($ibu) {
                            $tglLahir = Carbon::parse($ibu->tgl_lahir); // Get the birthdate of the mother
                            $tanggalPemeriksaan = $get('tanggal_pemeriksaan')
                                ? Carbon::parse($get('tanggal_pemeriksaan'))
                                : Carbon::now(); // Use the current date if no exam date is set

                            $usiaIbu = $tglLahir->diffInYears($tanggalPemeriksaan); // Calculate the age in years

                            // Log the result
                            logger()->info('Usia Ibu:', ['usia_ibu' => $usiaIbu]);

                            // Set usia_ibu field automatically
                            $set('usia_ibu', $usiaIbu);
                        }
                    }),
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
                TextInput::make('usia_ibu')
                    ->label('Usia Ibu (tahun)')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->disabled(),
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
                Tables\Columns\TextColumn::make('usia_ibu')
                    ->suffix(' tahun')
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
                Action::make('Cetak')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('cetak.pemeriksaan-ibu', $record->id))
                    ->openUrlInNewTab()
                    ->color('success'),
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
