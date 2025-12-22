<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductType;
use App\Enums\ProductCondition;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'sale_price', 'sku', 'stock_quantity',
        'is_visible', 'is_featured', 'is_new', 'brand_id', 'type', 'condition',
        'main_image_path', 'gallery_image_paths', 'colors', 'seo_title', 'seo_description', 'seo_keywords'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'gallery_image_paths' => 'array',
        'colors' => 'array',
        'seo_keywords' => 'array',
        'additional_info' => 'array',
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

    /**
     * Get the images attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
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
}
