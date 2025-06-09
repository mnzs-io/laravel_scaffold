<?php

namespace App\Models\MemoryCards;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'front', 'back', 'visible', 'topic_id', 'teacher_id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function getSubjectAttribute()
    {
        return $this->topic?->subject;
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', true);
    }
}
