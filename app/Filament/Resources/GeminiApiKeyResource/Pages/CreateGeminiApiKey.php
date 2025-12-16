<?php

namespace App\Filament\Resources\GeminiApiKeyResource\Pages;

use App\Filament\Resources\GeminiApiKeyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeminiApiKey extends CreateRecord
{
    protected static string $resource = GeminiApiKeyResource::class;
}
