<?php

namespace App\Models\MemoryCards;

use App\Traits\AutoSlug;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use AutoSlug, HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'secret',
        'color',
        'organization_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'course_subject');
    }

    public function topics()
    {
        return $this->hasManyThrough(Topic::class, Subject::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Topic::class);
    }
}
