<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\Pages\CreatePayment;
use App\Filament\Resources\Payments\Pages\EditPayment;
use App\Filament\Resources\Payments\Pages\ListPayments;
use App\Models\Payment;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Payments';

    protected static ?string $modelLabel = 'Payment';

    protected static ?string $pluralModelLabel = 'Payments';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'transaction_id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('transaction_id')
                    ->default(null),
                TextInput::make('payment_method')
                    ->default(null),
                TextInput::make('total_pembayaran')
                    ->numeric()
                    ->default(null),
                Select::make('payment_status')
                    ->options(['pending' => 'Pending', 'approve' => 'Approve', 'rejected' => 'Rejected', 'refund' => 'Refund'])
                    ->default(null),
                DateTimePicker::make('payment_time'),
                TextInput::make('bookings_id_booking')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('transaction_id')
            ->columns([
                TextColumn::make('transaction_id')
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('total_pembayaran')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge(),
                TextColumn::make('payment_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('bookings_id_booking')
                    ->numeric()
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPayments::route('/'),
            'create' => CreatePayment::route('/create'),
            'edit' => EditPayment::route('/{record}/edit'),
        ];
    }
}
