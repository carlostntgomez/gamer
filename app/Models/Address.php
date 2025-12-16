<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    protected $casts = [
        'type' => AddressType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordersAsShipping()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    public function ordersAsBilling()
    {
        return $this->hasMany(Order::class, 'billing_address_id');
    }

    // Accessor for full address
    public function getFullAddressAttribute(): string
    {
        $address = "{$this->address_line_1}";
        if ($this->address_line_2) {
            $address .= ", {$this->address_line_2}";
        }
        $address .= ", {$this->city}, {$this->state}, {$this->zip_code}, {$this->country}";
        return $address;
    }
}
