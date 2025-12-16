<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_slogan',
        'contact_email',
        'contact_phone',
        'address',
        'social_links',
        'logo_path',
        'favicon_path',
        'copyright_text',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
