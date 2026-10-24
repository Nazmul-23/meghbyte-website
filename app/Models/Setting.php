<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Read a setting (JSON values are decoded). Cached for 10 minutes. */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            $raw = Cache::remember("setting:{$key}", 600, fn () => static::query()->where('key', $key)->value('value'));
        } catch (Throwable) {
            return $default;
        }

        if ($raw === null) {
            return $default;
        }

        $decoded = json_decode($raw, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $raw;
    }

    public static function put(string $key, mixed $value): void
    {
        $stored = is_string($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE);
        static::query()->updateOrCreate(['key' => $key], ['value' => $stored]);
        Cache::forget("setting:{$key}");
    }
}
