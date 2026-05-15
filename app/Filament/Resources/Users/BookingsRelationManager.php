<?php

namespace App\Filament\Resources\Users;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $title = 'Status Sewa Kamar';

    protected static ?string $modelLabel = 'Sewa Kamar';

    protected static ?string $pluralModelLabel = 'Status Sewa Kamar';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('rooms_id_room')
                    ->label('Pilih Kamar')
                    ->options(
                        Room::where('status', 'tersedia')
                            ->get()
                            ->mapWithKeys(fn (Room $room) => [
                                $room->id_room => "Kamar {$room->no_kamar} — {$room->formatted_price}/bln ({$room->deskripsi})"
                            ])
                    )
                    ->required()
                    ->searchable()
                    ->helperText('Hanya menampilkan kamar yang statusnya "Tersedia".'),
                DatePicker::make('check_in')
                    ->label('Tanggal Masuk')
                    ->default(now())
                    ->required(),
                TextInput::make('durasi')
                    ->label('Durasi Sewa (Bulan)')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->maxValue(24)
                    ->required()
                    ->helperText('Total harga = Harga Kamar × Durasi.'),
                Select::make('status')
                    ->options([
                        'confirmed' => 'Confirmed (Langsung Aktif)',
                        'pending' => 'Pending (Menunggu Pembayaran)',
                    ])
                    ->default('confirmed')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_number')
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->copyable(),
                TextColumn::make('room.no_kamar')
                    ->label('No. Kamar'),
                TextColumn::make('room.deskripsi')
                    ->label('Kategori')
                    ->badge()
                    ->placeholder('-'),
                TextColumn::make('check_in')
                    ->label('Check-in')
                    ->date('d M Y'),
                TextColumn::make('payment.total_pembayaran')
                    ->label('Total Bayar')
                    ->numeric()
                    ->prefix('Rp ')
                    ->placeholder('-'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Input Penghuni Manual')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['invoice_number'] = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
                        return $data;
                    })
                    ->after(function ($record, array $data) {
                        $room = Room::find($record->rooms_id_room);
                        $durasi = (int) ($data['durasi'] ?? 1);
                        $totalPrice = ($room?->harga_perbulan ?? 0) * $durasi;

                        $paymentStatus = $record->status === 'confirmed' ? 'approve' : 'pending';

                        Payment::create([
                            'bookings_id_booking' => $record->id_booking,
                            'transaction_id' => $record->invoice_number,
                            'payment_method' => 'manual',
                            'total_pembayaran' => $totalPrice,
                            'payment_status' => $paymentStatus,
                            'payment_time' => now(),
                        ]);

                        if ($room) {
                            $room->update(['status' => 'tidak tersedia']);
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
