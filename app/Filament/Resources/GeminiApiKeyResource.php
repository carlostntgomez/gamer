<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeminiApiKeyResource\Pages;
use App\Models\GeminiApiKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class GeminiApiKeyResource extends Resource
{
    protected static ?string $model = GeminiApiKey::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'API Gemini';
    protected static ?string $pluralModelLabel = 'API Gemini';
    protected static ?string $navigationLabel = 'API Gemini';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Clave API de Google Gemini')
                    ->description('Introduce tu clave API para la integración con los servicios de IA de Google Gemini. Puedes obtener una desde Google AI Studio.')
                    ->schema([
                        Forms\Components\TextInput::make('api_key')
                            ->label('Clave API')
                            ->password()
                            ->required()
                            ->dehydrateStateUsing(fn ($state) => trim($state))
                            ->revealable()
                            ->maxLength(255)
                            ->helperText('Mantén esta clave segura. Se usará para acceder a los servicios de Gemini.'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function getPages(): array
    {
        return [
            // La entrada del menú apunta aquí. Esta página redirigirá al usuario.
            'index' => Pages\ListGeminiApiKeys::route('/'),
            // La página de edición real, con la ruta estándar que Filament espera.
            'edit' => Pages\EditGeminiApiKey::route('/{record}/edit'),
        ];
    }

    // Ocultamos el botón de "Nuevo" en la interfaz, ya que solo debe existir un registro.
    public static function canCreate(): bool
    {
        return false;
    }
}
