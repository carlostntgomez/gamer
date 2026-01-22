<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum OrderStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Shipped = 'shipped'; // Nuevo estado para 'Enviado y en camino'
    case Delivered = 'delivered'; // Renombrado de Completed
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'Pedido confirmado',
            self::Processing => 'En preparación',
            self::Shipped => 'Enviado y en camino',
            self::Delivered => 'Entregado',
            self::Cancelled => 'Cancelado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Processing => 'info',
            self::Shipped => 'primary', // Color para enviado
            self::Delivered => 'success',
            self::Cancelled => 'danger',
        };
    }
}