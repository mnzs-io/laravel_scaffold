<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFormattedAttribute(): string
    {
        $parts = [
            $this->street,
            $this->number ? ', ' . $this->number : '',
            $this->complement ? ' (' . $this->complement . ')' : '',
            ' - ' . $this->neighborhood,
            ', ' . $this->city . '/' . $this->state,
            ' - CEP: ' . $this->postal_code,
        ];

        return implode('', $parts);
    }
}
