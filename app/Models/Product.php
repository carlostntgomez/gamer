<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductType;
use App\Enums\ProductCondition;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description', 'long_description', 'price', 'sale_price', 'sku', 'stock_quantity',
        'is_visible', 'is_featured', 'is_new', 'brand_id', 'type', 'condition',
        'main_image_path', 'gallery_image_paths', 'colors', 'specifications', 'seo_title', 'seo_description', 'seo_keywords'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'gallery_image_paths' => 'array',
        'colors' => 'array',
        'specifications' => 'array',
        'seo_keywords' => 'array',
        'type' => ProductType::class,
        'condition' => ProductCondition::class,
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->categories->first(),
        );
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->main_image_path ? Storage::url($this->main_image_path) : asset('img/product/home1-pro-1.jpg')
        );
    }

    public function salePercent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                ($attributes['price'] > 0 && $attributes['sale_price'] > 0)
                ? round((($attributes['price'] - $attributes['sale_price']) / $attributes['price']) * 100)
                : 0
        );
    }

    public function compareAtPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['price']
        );
    }

    protected function images(): Attribute
    { 
        return Attribute::make(
            get: function () {
                $images = $this->gallery_image_paths ?? [];
                array_unshift($images, $this->main_image_path);
                return $images;
            },
        );
    }

    public function stock(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['stock_quantity'],
        );
    }
}
