<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected $cacheKey = 'app_settings';

    protected $cacheDuration = 3600;

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        return $settings[$key] ?? $default;
    }

    public function getGroup(string $prefix): array
    {
        $settings = $this->all();
        $group = [];

        foreach ($settings as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $group[$key] = $value;
            }
        }

        return $group;
    }

    public function set(string $key, mixed $value, string $type = 'string'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );

        $this->clearCache();
    }

    public function all(): array
    {
        return Cache::remember($this->cacheKey, $this->cacheDuration, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }
}
