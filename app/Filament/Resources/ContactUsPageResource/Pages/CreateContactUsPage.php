<?php

namespace App\Filament\Resources\ContactUsPageResource\Pages;

use App\Filament\Resources\ContactUsPageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactUsPage extends CreateRecord
{
    protected static string $resource = ContactUsPageResource::class;
}
