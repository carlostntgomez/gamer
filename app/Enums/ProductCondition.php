<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Livewire\Wireable;

enum ProductCondition: string implements HasLabel, HasColor, Wireable
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

    public function toLivewire()
    {
        return $this->value;
    }

    public static function fromLivewire($value)
    {
        return static::from($value);
    }
}
