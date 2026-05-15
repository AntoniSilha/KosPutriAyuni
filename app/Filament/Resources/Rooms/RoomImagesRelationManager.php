<?php

namespace App\Filament\Resources\Rooms;

use App\Models\RoomImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;

class RoomImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Foto Kamar';

    protected static ?string $modelLabel = 'Foto';

    protected static ?string $pluralModelLabel = 'Foto Kamar';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('img_url')
                    ->label('Upload Foto Kamar')
                    ->image()
                    ->directory('rooms')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Unggah file gambar dari komputer Anda (jpg, png, webp).'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('img_url')
                    ->label('Preview')
                    ->height(80)
                    ->width(120),
                TextColumn::make('img_url')
                    ->label('URL')
                    ->limit(50)
                    ->copyable(),
                TextColumn::make('id_image')
                    ->label('ID'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Foto'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
