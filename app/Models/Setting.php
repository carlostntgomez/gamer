<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string|null $site_name
 * @property string|null $site_slogan
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property string|null $address
 * @property array|null $social_links
 * @property string|null $logo_path
 * @property string|null $favicon_path
 * @property string|null $copyright_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'social_links' => 'array',
    ];
}
