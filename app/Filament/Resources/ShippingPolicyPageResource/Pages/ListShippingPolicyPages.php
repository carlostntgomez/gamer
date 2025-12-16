<?php

namespace App\Filament\Resources\ShippingPolicyPageResource\Pages;

use App\Filament\Resources\ShippingPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

class ListShippingPolicyPages extends ListRecords
{
    protected static string $resource = ShippingPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action for singleton pages
        ];
    }

    public function mount(): void
    {
        $page = $this->getResource()::getEloquentQuery()->firstOrFail();
        $this->redirect($this->getResource()::getUrl('edit', ['record' => $page->id]));
    }
}
