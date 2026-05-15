<?php

namespace App\Filament\Resident\Pages;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $title = 'Profile';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'profile';

    protected string $view = 'filament.resident.pages.edit-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();

        $this->form->fill([
            'avatar' => $this->findAvatarPath((int) $user->id_user),
            'name' => $user->name,
            'email' => $user->email,
            'no_hp' => $user->no_hp,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Foto Profil')
                    ->description('Perbarui foto profil Anda agar mudah dikenali.')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Foto Profil')
                            ->avatar()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('avatars')
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): ?string {
                                if (! $file->exists()) {
                                    return null;
                                }

                                $userId = (int) auth()->user()->id_user;
                                $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                                $extension = $extension === 'jpeg' ? 'jpg' : $extension;

                                if (! in_array($extension, ['jpg', 'png', 'webp'], true)) {
                                    $extension = 'jpg';
                                }

                                $this->deleteExistingAvatars($userId);

                                $path = $file->storeAs('avatars', "user_{$userId}.{$extension}", 'public');
                                Storage::disk('public')->setVisibility($path, 'public');

                                return $path;
                            })
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->imagePreviewHeight('250')
                            ->openable()
                            ->downloadable()
                            ->maxSize(12288),
                    ]),

                Section::make('Informasi Pribadi')
                    ->description('Data nama dan email hanya dapat diubah oleh Administrator.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(User::class, 'email', ignorable: auth()->user()),
                    ]),

                Section::make('Kontak & Keamanan')
                    ->description('Pastikan nomor WhatsApp aktif untuk menerima notifikasi tagihan.')
                    ->schema([
                        TextInput::make('no_hp')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->maxLength(13)
                            ->required(),
                        
                        Grid::make(2)
                            ->schema([
                                TextInput::make('new_password')
                                    ->label('Password Baru')
                                    ->password()
                                    ->rule(Password::default()),
                                TextInput::make('new_password_confirmation')
                                    ->label('Konfirmasi Password')
                                    ->password()
                                    ->same('new_password')
                                    ->requiredWith('new_password'),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            $user = auth()->user();

            $updateData = [
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'no_hp' => $data['no_hp'],
            ];

            if (!empty($data['new_password'])) {
                // Model already has 'hashed' cast on password, so pass plain text
                $updateData['password'] = $data['new_password'];
            }

            $user->update($updateData);

            // Clear sensitive fields
            $this->data['new_password'] = null;
            $this->data['new_password_confirmation'] = null;

            // Refresh avatar path to reflect current stored file
            $this->data['avatar'] = $this->findAvatarPath((int) $user->id_user);

            Notification::make()
                ->title('Profil Berhasil Diperbarui')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Memperbarui Profil')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function findAvatarPath(int $userId): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $path = "avatars/user_{$userId}.{$extension}";

            if (Storage::disk('public')->exists($path)) {
                return $path;
            }
        }

        return null;
    }

    protected function deleteExistingAvatars(int $userId): void
    {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $path = "avatars/user_{$userId}.{$extension}";

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
