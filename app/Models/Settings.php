<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    /** @use HasFactory<\Database\Factories\SettingsFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'group',
        'type',
        'label',
        'key',
        'value',
    ];

    public static function test($key)
    {
        $settings = Cache::get('settings');

        return (bool) ($settings[$key] ?? false);
    }

    public static function if($key, Closure $closure)
    {
        if (self::test($key)) {
            $closure();
        }
    }

    public function getValueAttribute($value)
    {
        return match ($this->type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            default => $value,
        };
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = match ($this->type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0',
            'integer' => (string) (int) $value,
            default => $value,
        };
    }
}
