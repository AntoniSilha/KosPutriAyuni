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

        // Fallback to inline SVG initials avatar (no external dependency)
        $initials = collect(explode(' ', $record->name))
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->take(2)
            ->implode('');

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128">'
             . '<rect width="128" height="128" fill="%23FDFBF7"/>'
             . '<text x="64" y="64" dy=".35em" text-anchor="middle" font-family="sans-serif" font-size="48" font-weight="600" fill="%238C6A4F">'
             . $initials
             . '</text></svg>';

        return 'data:image/svg+xml,' . $svg;
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
