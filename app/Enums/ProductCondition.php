<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum ProductCondition: string implements HasLabel, HasColor
{
    case New = 'nuevo';
    case Used = 'usado';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => 'Nuevo',
            self::Used => 'Usado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::New => 'success',
            self::Used => 'warning',
        };
    }

}
