<?php

namespace App\Models\MemoryCards;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'logo_url',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function subjects(): HasMany
    {
        return $this->hasMany(\App\Models\MemoryCards\Subject::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'associations')
            ->withPivot('role', 'active')
            ->withTimestamps();
    }

    public function teachers()
    {
        return User::whereHas('associations', function ($query) {
            $query->where('role', Role::TEACHER)
                ->where('associable_type', Subject::class)
                ->whereIn('associable_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('subjects')
                        ->where('organization_id', $this->id);
                });
        })->get();
    }

    public function address()
    {
        return $this->morphOne(\App\Models\Address::class, 'addressable');
    }
}
