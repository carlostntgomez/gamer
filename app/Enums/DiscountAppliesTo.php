<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DiscountAppliesTo: string implements HasLabel
{
    case Order = 'order';
    case Products = 'products';
    case Categories = 'categories';

    public function getLabel(): string
    {
        return match ($this) {
            self::Order => 'Pedido Completo',
            self::Products => 'Productos Específicos',
            self::Categories => 'Categorías Específicas',
        };
    }
}