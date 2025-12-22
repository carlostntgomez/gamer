<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'image_path',
        'banner_path',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    protected $casts = [
        'seo_keywords' => 'array',
    ];

    protected $appends = [
        'image_url',
        'banner_url',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path ? Storage::url($this->image_path) : null,
        );
    }

    protected function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->banner_path ? Storage::url($this->banner_path) : null,
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Category $category) {
            $category->children()->update(['parent_id' => null]);
        });
    }
}
