<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemeriksaanAnakResource\Pages;
use App\Models\Anak;
use App\Models\Bidan;
use App\Models\Imunisasi;
use App\Models\PemeriksaanAnak;
use App\Models\Vitamin;
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

class PemeriksaanAnakResource extends Resource
{
    protected static ?string $model = PemeriksaanAnak::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pemeriksaan Anak';

    protected static ?string $navigationGroup = 'KMS (Kartu Menuju Sehat)';

    protected static ?string $label = "Kelola Data Pemeriksaan Anak";

    protected static ?string $slug = "kelola-data/pemeriksaan-anak";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal_pemeriksaan')
                    ->label('Tanggal Pemeriksaan')
                    ->required()
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        logger()->info('State tanggal_pemeriksaan:', ['state' => $state, 'anak_id' => $get('anak_id')]);

                        $anak = Anak::find($get('anak_id'));

                        if ($anak) {
                            $tglLahir = Carbon::parse($anak->tgl_lahir);
                            $tanggalPemeriksaan = Carbon::parse($state);
                            $usiaBalita = $tglLahir->diffInMonths($tanggalPemeriksaan);

                            // Set usia balita secara otomatis
                            $set('usia_balita', $usiaBalita);
                        }
                    }),

                Select::make('anak_id')
                    ->label('Nama Anak')
                    ->required()
                    ->options(Anak::all()->pluck('nama_lengkap', 'id'))
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        logger()->info('State anak_id:', ['state' => $state, 'tanggal_pemeriksaan' => $get('tanggal_pemeriksaan'), 'anak' => Anak::find($state)]);

                        $anak = Anak::find($state);

                        if ($anak) {
                            $tglLahir = Carbon::parse($anak->tgl_lahir);
                            $tanggalPemeriksaan = $get('tanggal_pemeriksaan')
                                ? Carbon::parse($get('tanggal_pemeriksaan'))
                                : Carbon::now();

                            $usiaBalita = $tglLahir->diffInMonths($tanggalPemeriksaan);

                            // Log hasil perhitungan usia balita
                            logger()->info('Usia Balita:', ['usia_balita' => $usiaBalita]);

                            // Set usia balita secara otomatis
                            $set('usia_balita', $usiaBalita);
                        }
                    }),

                TextInput::make('usia_balita')
                    ->label('Usia Balita (bulan)')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->disabled(),

                Select::make('bidan_id')
                    ->label('Nama Bidan')
                    ->required()
                    ->options(Bidan::all()->pluck('nama_lengkap', 'id')),

                Select::make('imunisasi_id')
                    ->label('Jenis Imunisasi')
                    ->required()
                    ->options(Imunisasi::all()->pluck('jenis_imunisasi', 'id')),

                Select::make('vitamin_id')
                    ->label('Jenis Vitamin')
                    ->required()
                    ->options(Vitamin::all()->pluck('jenis_vitamin', 'id')),

                TextInput::make('berat_badan')
                    ->label('Berat Badan (kg)')
                    ->required()
                    ->numeric(),
                TextInput::make('tinggi_badan')
                    ->label('Tinggi Badan (cm)')
                    ->required()
                    ->numeric(),
                TextInput::make('saran')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('anak.nama_lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bidan.nama_lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('imunisasi.jenis_imunisasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('vitamin.jenis_vitamin')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_pemeriksaan')
                    ->searchable()
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('usia_balita')
                    ->searchable()
                    ->suffix(' bulan')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('berat_badan')
                    ->searchable()
                    ->suffix(' kg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->searchable()
                    ->suffix('cm')
                    ->numeric()
                    ->sortable(),
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
                    ->url(fn($record) => route('pemeriksaan-anak.cetak', $record->id))
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
            'index' => Pages\ListPemeriksaanAnaks::route('/'),
            'create' => Pages\CreatePemeriksaanAnak::route('/create'),
            'view' => Pages\ViewPemeriksaanAnak::route('/{record}'),
            'edit' => Pages\EditPemeriksaanAnak::route('/{record}/edit'),
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
