<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case CONTRAENTREGA = 'Contraentrega';
    case RECOGER_EN_TIENDA = 'Recoger en Tienda';
    case TRANSFERENCIA_BANCARIA = 'bank_transfer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CONTRAENTREGA => 'Contraentrega',
            self::RECOGER_EN_TIENDA => 'Recoger en Tienda',
            self::TRANSFERENCIA_BANCARIA => 'Transferencia Bancaria',
        };
    }
}
