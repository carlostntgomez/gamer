<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum ProductType: string implements HasLabel, HasColor
{
    case Gadget = 'gadget';
    case Videogame = 'videojuego';
    case Accessory = 'accesorio';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Gadget => 'Gadget',
            self::Videogame => 'Videojuego',
            self::Accessory => 'Accesorio',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Gadget => 'primary',
            self::Videogame => 'success',
            self::Accessory => 'warning',
        };
    }
}
