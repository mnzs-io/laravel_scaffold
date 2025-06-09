<?php

namespace App\Models\MemoryCards;

use App\Traits\AutoSlug;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use AutoSlug, HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'slug', 'subject_id', 'color', 'description'];

    protected $hidden = ['created_at', 'updated_at'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function authors()
    {
        return $this->cards()->with('user')->get()->pluck('user.profile_photo_url', 'user.name')->map(function ($photo, $name) {
            return [
                'name' => $name,
                'photo' => $photo,
            ];
        })->unique('name')->values();
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
