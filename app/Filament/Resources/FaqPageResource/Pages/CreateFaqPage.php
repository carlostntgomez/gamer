<?php

namespace App\Filament\Resources\FaqPageResource\Pages;

use App\Filament\Resources\FaqPageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFaqPage extends CreateRecord
{
    protected static string $resource = FaqPageResource::class;
}
