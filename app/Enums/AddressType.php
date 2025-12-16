<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AddressType: string implements HasLabel, HasColor
{
    case Shipping = 'shipping';
    case Billing = 'billing';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Shipping => 'Envío',
            self::Billing => 'Facturación',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Shipping => 'primary',
            self::Billing => 'secondary',
        };
    }
}