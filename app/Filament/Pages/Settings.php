<?php

namespace App\Filament\Pages;

use App\Services\SettingsService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan & Info';
    protected static ?string $title = 'Pengaturan & Informasi';
    protected static ?int $navigationSort = 5;
    protected static ?string $slug = 'settings';

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(SettingsService::class)->all();

        $this->form->fill([
            'wifi_ssid' => $settings['wifi_ssid'] ?? 'Kos Putri Ayuni',
            'wifi_password' => $settings['wifi_password'] ?? '',
            'info_text' => $settings['info_text'] ?? '',
            'announcements' => $settings['announcements'] ?? [],
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Informasi WiFi')
                    ->description('Informasi ini akan ditampilkan di Dashboard Penghuni.')
                    ->schema([
                        TextInput::make('wifi_ssid')
                            ->label('Nama WiFi (SSID)')
                            ->required(),
                        TextInput::make('wifi_password')
                            ->label('Password WiFi')
                            ->required(),
                    ]),

                Section::make('Informasi Umum')
                    ->description('Teks informasi tambahan yang ditampilkan di Dashboard Penghuni.')
                    ->schema([
                        Textarea::make('info_text')
                            ->label('Informasi Tambahan')
                            ->rows(3)
                            ->placeholder('Contoh: Pembayaran dilakukan setiap tanggal 5...'),
                    ]),

                Section::make('Pengumuman')
                    ->description('Tambah pengumuman penting yang akan ditampilkan di Dashboard Penghuni.')
                    ->schema([
                        Repeater::make('announcements')
                            ->label('')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Pengumuman')
                                    ->required(),
                                Textarea::make('description')
                                    ->label('Isi Pengumuman')
                                    ->required()
                                    ->rows(2),
                                TextInput::make('date')
                                    ->label('Tanggal (contoh: MEI 03)')
                                    ->required()
                                    ->default(strtoupper(now()->translatedFormat('M d'))),
                            ])
                            ->addActionLabel('Tambah Pengumuman')
                            ->reorderable()
                            ->maxItems(10)
                            ->defaultItems(0),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        app(SettingsService::class)->save([
            'wifi_ssid' => $data['wifi_ssid'] ?? '',
            'wifi_password' => $data['wifi_password'] ?? '',
            'info_text' => $data['info_text'] ?? '',
            'announcements' => $data['announcements'] ?? [],
        ]);

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->success()
            ->send();
    }
}
