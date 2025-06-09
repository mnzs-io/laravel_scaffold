<?php

namespace App\Models;

use App\Enums\Role;
use App\Models\MemoryCards\Organization;
use App\Models\MemoryCards\Subject;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

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

    public function setNameAttribute(string $name): void
    {
        $this->attributes['name'] = Stringable::apaPtBr($name);
    }

    public function associations(): HasMany
    {
        return $this->hasMany(Association::class);
    }

    public function organizations(): Collection
    {
        return $this->associations()
            ->where('role', Role::ADMIN)
            ->where('associable_type', Organization::class)
            ->with('associable')
            ->get()
            ->pluck('associable');
    }

    public function disciplines(): Collection
    {
        return $this->associations()
            ->where('role', Role::TEACHER)
            ->where('associable_type', Subject::class)
            ->with('associable')
            ->get()
            ->pluck('associable');
    }

    public function hasRole(Role $role, ?string $associableType = null, ?string $associableId = null): bool
    {
        return $this->associations()
            ->where('role', $role)
            ->when($associableType && $associableId, function ($query) use ($associableType, $associableId) {
                $query->where('associable_type', $associableType)
                    ->where('associable_id', $associableId);
            })
            ->exists();
    }

    public function assignTo(string $role, Model $associable): void
    {
        $this->associations()->create([
            'role' => $role,
            'associable_id' => $associable->id,
            'associable_type' => get_class($associable),
        ]);
    }

    public function address()
    {
        return $this->morphOne(\App\Models\Address::class, 'addressable');
    }
}
