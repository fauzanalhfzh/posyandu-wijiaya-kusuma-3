<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemeriksaanAnakResource\Pages;
use App\Filament\Resources\PemeriksaanAnakResource\RelationManagers;
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
                Select::make('anak_id')
                    ->label('Nama Anak')
                    ->required()
                    ->options(Anak::all()->pluck('nama_lengkap', 'id'))
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        // Debugging: Menulis data ke log
                        logger()->info('State anak_id:', ['state' => $state, 'tanggal_pemeriksaan' => $get('tanggal_pemeriksaan'), 'anak' => Anak::find($state)]);

                        // Mengambil data anak berdasarkan anak_id
                        $anak = Anak::find($state);

                        if ($anak) {
                            // Menghitung usia balita berdasarkan tanggal lahir dan tanggal pemeriksaan
                            $tglLahir = Carbon::parse($anak->tgl_lahir);

                            // Mendapatkan tanggal pemeriksaan, jika ada
                            $tanggalPemeriksaan = $get('tanggal_pemeriksaan')
                                ? Carbon::parse($get('tanggal_pemeriksaan'))
                                : Carbon::now(); // Jika tanggal pemeriksaan tidak diisi, gunakan tanggal saat ini

                            // Menghitung usia balita dalam bulan (selisih bulan antara tanggal lahir dan tanggal pemeriksaan)
                            $usiaBalita = $tglLahir->diffInMonths($tanggalPemeriksaan);

                            // Set usia balita secara otomatis
                            $set('usia_balita', $usiaBalita);
                        }
                    }),

                DatePicker::make('tanggal_pemeriksaan')
                    ->minDate(now()) // Pastikan tanggal minimum adalah hari ini
                    ->required()
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        // Debugging: Menampilkan data yang diambil setelah tanggal_pemeriksaan diupdate
                        dd(
                            'State tanggal_pemeriksaan:',
                            $state,
                            'Anak ID:',
                            $get('anak_id'),
                            'Anak Data:',
                            Anak::find($get('anak_id'))
                        );

                        // Mengambil data anak berdasarkan anak_id untuk menghitung usia balita setelah tanggal_pemeriksaan diperbarui
                        $anak = Anak::find($get('anak_id')); // Mengambil anak_id saat ini

                        if ($anak) {
                            // Menghitung usia balita berdasarkan tanggal lahir dan tanggal pemeriksaan
                            $tglLahir = Carbon::parse($anak->tgl_lahir);

                            // Mengambil tanggal pemeriksaan yang baru
                            $tanggalPemeriksaan = Carbon::parse($state);

                            // Menghitung usia balita dalam bulan (selisih bulan antara tanggal lahir dan tanggal pemeriksaan)
                            $usiaBalita = $tglLahir->diffInMonths($tanggalPemeriksaan);

                            // Set usia balita secara otomatis
                            $set('usia_balita', $usiaBalita);
                        }
                    }),

                TextInput::make('usia_balita')
                    ->label('Usia Balita (bulan)')
                    ->required()
                    ->numeric()
                    ->disabled(), // Non-editable karena dihitung otomatis
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
