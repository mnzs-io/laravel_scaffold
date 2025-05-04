<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait Uuid
{
    protected static function uuidBooted($prefix): void
    {
        static::creating(callback: function (Model $model) use ($prefix) {
            $model->id = self::uuid($prefix);
        });
    }

    public static function uuid($prefix)
    {
        return str()->uuid()->toString();
    }
}
