<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'apartment',
        'city',
        'state',
        'country',
        'neighborhood',
    ];

    protected $casts = [
        'type' => AddressType::class,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Accessor for a complete, formatted string of the address.
     */
    public function getFullAddressAttribute(): string
    {
        $addressParts = [
            $this->address,
            $this->apartment,
            $this->neighborhood,
            $this->city,
            $this->state,
            $this->country,
        ];
        return implode(', ', array_filter($addressParts));
    }
}
