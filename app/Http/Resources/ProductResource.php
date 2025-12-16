<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'is_featured' => $this->is_featured,
            'sku' => $this->sku,
            'sale_price' => $this->sale_price,
            'vendor' => $this->vendor,
            'type' => $this->type,
            'other_content' => $this->other_content,
            'colors' => $this->colors,
            'video_url' => $this->video_url,
            'additional_info' => $this->additional_info,
            'delivery_date_message' => $this->delivery_date_message,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'slug' => $this->slug,
            'condition' => $this->condition,
            'brand_id' => $this->brand_id,
            'main_image' => $this->formatMedia($this->getFirstMedia('main_image')),
            'gallery_images' => $this->getMedia('gallery_images')->map(function ($media) {
                return $this->formatMedia($media);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    protected function formatMedia($media)
    {
        if (!$media) {
            return null;
        }

        return [
            'original' => $media->getUrl(),
            'thumb' => $media->getUrl('thumb'),
            'medium' => $media->getUrl('medium'),
            'large' => $media->getUrl('large'),
            'thumb_webp' => $media->getUrl('thumb-webp'),
            'medium_webp' => $media->getUrl('medium-webp'),
            'large_webp' => $media->getUrl('large-webp'),
        ];
    }
}
