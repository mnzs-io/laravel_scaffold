<?php

namespace App\Traits;

trait AutoSlug
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
        $this->attributes['slug'] = str()->slug($this->attributes['name']);
    }
}
