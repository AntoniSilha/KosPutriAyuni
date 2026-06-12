<?php

namespace App\Filament\Resources\Rooms;

use App\Filament\Resources\Rooms\Pages\CreateRoom;
use App\Filament\Resources\Rooms\Pages\EditRoom;
use App\Filament\Resources\Rooms\Pages\ListRooms;
use App\Models\Room;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Manajemen Kamar';

    protected static ?string $modelLabel = 'Kamar';

    protected static ?string $pluralModelLabel = 'Manajemen Kamar';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'no_kamar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_kamar')
                    ->required()
                    ->maxLength(3)
                    ->label('Nomor Kamar')
                    ->helperText('Maksimal 3 karakter (contoh: 01, A1).'),
                Select::make('deskripsi.tipe_kamar')
                    ->label('Kategori Kamar')
                    ->options([
                        'Reguler' => 'Reguler',
                        'Large' => 'Large',
                    ])
                    ->required()
                    ->helperText('Pilih kategori kamar. Kategori ini akan menentukan label di halaman depan.'),
                Textarea::make('deskripsi.teks_deskripsi')
                    ->label('Deskripsi Kamar')
                    ->helperText('Isi penjelasan detail mengenai fasilitas atau deskripsi kamar.')
                    ->columnSpanFull(),
                TextInput::make('harga_perbulan')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga per Bulan'),
                Select::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'tidak tersedia' => 'Tidak tersedia',
                        'perbaikan' => 'Sedang Perbaikan',
                    ])
                    ->default('tersedia')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('no_kamar')
            ->columns([
                TextColumn::make('no_kamar')
                    ->label('No. Kamar')
                    ->searchable(),
                TextColumn::make('deskripsi.tipe_kamar')
                    ->label('Kategori')
                    ->badge()
                    ->placeholder('Belum diatur'),
                TextColumn::make('harga_perbulan')
                    ->label('Harga / Bulan')
                    ->numeric()
                    ->prefix('Rp ')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RoomImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRooms::route('/'),
            'create' => CreateRoom::route('/create'),
            'edit' => EditRoom::route('/{record}/edit'),
        ];
    }
}
