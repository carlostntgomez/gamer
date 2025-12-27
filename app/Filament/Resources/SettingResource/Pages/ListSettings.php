<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class ListSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.list-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->all();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información General del Sitio')
                    ->schema([
                        TextInput::make('copyright_text')
                            ->label('Texto del Copyright'),
                    ]),

                Section::make('Datos de la Empresa y Legales')
                    ->schema([
                         TextInput::make('company_name')
                            ->label('Nombre de la Empresa'),
                        Grid::make(2)->schema([
                            TextInput::make('legal_country')
                                ->label('País para Ley Aplicable'),
                            TextInput::make('legal_jurisdiction_city')
                                ->label('Ciudad para Jurisdicción'),
                        ]),
                    ]),

                Section::make('Información de Contacto')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('phone')
                                ->label('Teléfono')
                                ->tel(),
                            TextInput::make('email')
                                ->label('Email')
                                ->email(),
                        ]),
                        Textarea::make('address')
                            ->label('Dirección')
                            ->rows(3),
                    ]),

                Section::make('Redes Sociales')
                    ->description('URLs completas de las redes sociales de la empresa.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('facebook_url')->label('Facebook')->url(),
                            TextInput::make('instagram_url')->label('Instagram')->url(),
                            TextInput::make('twitter_url')->label('Twitter / X')->url(),
                            TextInput::make('pinterest_url')->label('Pinterest')->url(),
                            TextInput::make('linkedin_url')->label('LinkedIn')->url(),
                            TextInput::make('youtube_url')->label('YouTube')->url(),
                        ]),
                    ]),

                Section::make('Contenido de Políticas')
                    ->schema([
                        Textarea::make('terms_conditions_content')
                            ->label('Términos y Condiciones')
                            ->rows(10),
                        Textarea::make('privacy_policy_content')
                            ->label('Política de Privacidad')
                            ->rows(10),
                        Textarea::make('return_policy_content')
                            ->label('Política de Devoluciones')
                            ->rows(10),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar cambios')
                ->submit('save'),
        ];
    }

    public function getTitle(): string
    {
        return 'Configuración del Sitio';
    }
}
