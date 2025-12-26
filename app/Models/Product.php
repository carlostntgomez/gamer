<?php

namespace App\Models;

use App\Enums\ProductCondition;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'gallery_image_paths' => 'array',
        'colors' => 'array',
        'specifications' => 'array',
        'seo_keywords' => 'array',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'type' => ProductType::class,
        'condition' => ProductCondition::class,
    ];

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'specifications',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'is_visible',
        'is_featured',
        'is_new',
        'brand_id',
        'type',
        'condition',
        'colors',
        'main_image_path',
        'gallery_image_paths',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
