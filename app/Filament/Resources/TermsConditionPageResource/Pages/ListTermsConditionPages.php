<?php

namespace App\Filament\Resources\TermsConditionPageResource\Pages;

use App\Filament\Resources\TermsConditionPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Facades\Filament; // Import Filament facade
use Illuminate\Database\Eloquent\Builder; // Import Builder

class ListTermsConditionPages extends ListRecords
{
    protected static string $resource = TermsConditionPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action for singleton pages
        ];
    }

    public function mount(): void
    {
        // Redirect directly to the edit page of the specific record
        $page = $this->getResource()::getEloquentQuery()->firstOrFail();
        
        $this->redirect($this->getResource()::getUrl('edit', ['record' => $page->id]));
    }
}
