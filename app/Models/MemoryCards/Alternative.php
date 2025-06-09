<?php

namespace App\Models\MemoryCards;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternative extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'text',
        'is_correct',
        'question_id',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at', 'is_correct', 'question_id'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
