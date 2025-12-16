<?php

namespace App\Filament\Resources\FaqPageResource\Pages;

use App\Filament\Resources\FaqPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

class ListFaqPages extends ListRecords
{
    protected static string $resource = FaqPageResource::class;

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
