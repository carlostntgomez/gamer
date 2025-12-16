<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TicketStatus: string implements HasColor, HasLabel
{
    case OPEN = 'open';
    case PENDING = 'pending';
    case CLOSED = 'closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::OPEN => 'Abierto',
            self::PENDING => 'Pendiente',
            self::CLOSED => 'Cerrado',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OPEN => 'success',
            self::PENDING => 'warning',
            self::CLOSED => 'danger',
        };
    }
}
