<?php

namespace App\Models;

use App\Contracts\Payment\PaymentCustomer;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Stringable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements PaymentCustomer
{
    use HasFactory, HasRoles, HasUuids, Notifiable;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'force_password_reset',
        'github_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'force_password_reset' => 'boolean',
        ];
    }

    public function setNameAttribute(string $name)
    {
        $this->attributes['name'] = Stringable::apaPtBr($name);
    }
}
