<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealOfTheDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'deal_price',
        'end_date',
    ];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
