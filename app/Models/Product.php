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
        'video_url',
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

    public function getYoutubeEmbedUrl(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        // This regex handles various YouTube URL formats.
        $regex = '~^(?:https?://)?(?:www\.)?(?:m\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:\S*)?$~';

        if (preg_match($regex, $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return null;
    }

    /**
     * Calcula la calificación promedio de las reseñas aprobadas.
     *
     * @return float
     */
    public function averageRating(): float
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

    /**
     * Convierte la calificación promedio a un porcentaje.
     *
     * @return float
     */
    public function averageRatingInPercent(): float
    {
        return ($this->averageRating() / 5) * 100;
    }

    /**
     * Generates the HTML for the star rating display.
     *
     * @return string
     */
    public function getStarRatingHtml(): string
    {
        $rating = $this->averageRating();
        $html = '<span class="pro-ratting">';

        if ($rating > 0) {
            $fullStars = floor($rating);
            $halfStar = round($rating - $fullStars, 1) >= 0.5;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

            for ($i = 0; $i < $fullStars; $i++) {
                $html .= '<i class="fas fa-star"></i>';
            }

            if ($halfStar) {
                $html .= '<i class="fas fa-star-half-alt"></i>';
            }

            for ($i = 0; $i < $emptyStars; $i++) {
                $html .= '<i class="far fa-star"></i>';
            }
        } else {
            // If no rating, show 5 empty stars
            for ($i = 0; $i < 5; $i++) {
                $html .= '<i class="far fa-star"></i>';
            }
        }

        $html .= '</span>';
        return $html;
    }
}
