<?php

namespace App\Models;

use App\Enums\DiscountAppliesTo;
use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_amount',
        'max_uses',
        'uses',
        'starts_at',
        'expires_at',
        'is_active',
        'applies_to',
        'product_ids',
        'category_ids',
    ];

    protected $casts = [
        'type' => DiscountType::class,
        'applies_to' => DiscountAppliesTo::class,
        'value' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'product_ids' => 'array',
        'category_ids' => 'array',
    ];
}
