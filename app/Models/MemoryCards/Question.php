<?php

namespace App\Models\MemoryCards;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

class Question extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'statement',
        'comment',
        'topic_id',
        'image',
        'teacher_id',
        'visible',
    ];

    protected $with = ['alternatives'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function alternatives(): HasMany
    {
        return $this->hasMany(Alternative::class);
    }

    public function correctAlternative(): ?Alternative
    {
        return $this->alternatives->where('is_correct', true)->first();
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function authors(): Collection
    {
        return $this->questions()->with('user')->get()->pluck('user.profile_photo_url', 'user.name')->map(function ($photo, $name) {
            return [
                'name' => $name,
                'photo' => $photo,
            ];
        })->unique('name')->values();
    }

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class, Topic::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
