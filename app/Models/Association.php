<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Association extends Model
{
    protected $fillable = ['user_id', 'role', 'associable_id', 'associable_type'];

    protected $casts = [
        'role' => Role::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function associable(): MorphTo
    {
        return $this->morphTo();
    }
}
