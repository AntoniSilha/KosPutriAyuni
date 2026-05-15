<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CustomAvatarProvider implements AvatarProvider
{
    public function get(Model $record): string
    {
        $avatarPath = $this->findAvatarPath((int) $record->id_user);

        if ($avatarPath) {
            $version = Storage::disk('public')->lastModified($avatarPath);

            return asset('storage/' . $avatarPath) . '?v=' . $version;
        }

        // Fallback to UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=8C6A4F&background=FDFBF7';
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
}
