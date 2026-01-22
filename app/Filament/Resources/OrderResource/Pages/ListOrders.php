<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['orderItems', 'billingAddress', 'latestStatusHistory']);
    }
}