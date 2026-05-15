<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SettingsService
{
    protected string $file = 'settings.json';

    /**
     * Get all settings
     */
    public function all(): array
    {
        if (!Storage::disk('local')->exists($this->file)) {
            return $this->defaults();
        }

        $content = Storage::disk('local')->get($this->file);
        $data = json_decode($content, true);

        return array_merge($this->defaults(), $data ?? []);
    }

    /**
     * Get a single setting
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        return $settings[$key] ?? $default;
    }

    /**
     * Save settings
     */
    public function save(array $data): void
    {
        $current = $this->all();
        $merged = array_merge($current, $data);

        Storage::disk('local')->put($this->file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Get announcements
     */
    public function getAnnouncements(): array
    {
        return $this->get('announcements', []);
    }

    /**
     * Get default settings
     */
    protected function defaults(): array
    {
        return [
            'wifi_password' => '',
            'wifi_ssid' => 'Kos Putri Ayuni',
            'announcements' => [],
            'info_text' => '',
        ];
    }
}
