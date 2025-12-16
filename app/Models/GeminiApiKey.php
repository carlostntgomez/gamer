<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GeminiApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key',
    ];

    /**
     * Interact with the api_key attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function apiKey(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null
        );
    }
}
