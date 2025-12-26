<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sort_order',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
