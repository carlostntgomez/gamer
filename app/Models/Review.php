<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'user_id', 
        'guest_name', 
        'guest_email', 
        'rating', 
        'title', 
        'comment', 
        'is_approved'
    ];

    /**
     * Obtiene el producto asociado a la reseña.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Obtiene el usuario que escribió la reseña (si está registrado).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Devuelve el HTML de las estrellas de calificación.
     */
    public function getStarRatingHtml()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
        }
        return $html;
    }

    /**
     * Accesor para obtener el nombre del autor de la reseña.
     * Devolverá el nombre del usuario si está registrado, o el nombre de invitado en caso contrario.
     */
    public function getAuthorNameAttribute()
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }
}
