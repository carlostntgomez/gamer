<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Actions as FormActions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class GeminiApiSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'API Gemini';
    protected static ?string $title = 'Configuración de la API de Gemini';

    protected static string $view = 'filament.pages.gemini-api-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'api_key' => config('gemini.api_key'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make('Clave API de Gemini')
                    ->description('Gestiona y prueba tu clave API de Gemini. La clave se guardará de forma segura en el archivo .env de tu aplicación.')
                    ->schema([
                        TextInput::make('api_key')
                            ->label('Clave API')
                            ->password()
                            ->revealable()
                            ->placeholder('Introduce tu nueva clave API de Gemini')
                            ->helperText('Esta clave nunca se guardará en la base de datos.'),
                        
                        FormActions::make([
                            FormActions\Action::make('save_api_key')
                                ->label('Guardar Clave en .env')
                                ->submit('save'),
                            
                            FormActions\Action::make('test_api_key')
                                ->label('Probar Conexión')
                                ->icon('heroicon-o-bolt')
                                ->color('gray')
                                ->action(function () {
                                    $apiKey = $this->data['api_key'];
                                    if (empty($apiKey)) {
                                        Notification::make()->title('Error')->body('Introduce una clave API para probarla.')->danger()->send();
                                        return;
                                    }
                                    try {
                                        $response = Http::withHeaders(['Content-Type' => 'application/json'])
                                            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=' . $apiKey, [
                                                'contents' => [['parts' => [['text' => 'Hola, ¿estás funcionando?']]]]
                                            ]);
                                        if ($response->successful()) {
                                            Notification::make()->title('¡Conexión Exitosa!')->body('La clave API es válida y el modelo gemini-3-flash-preview está accesible.')->success()->send();
                                        } else {
                                            $errorBody = $response->json();
                                            $errorMessage = $errorBody['error']['message'] ?? 'Error desconocido.';
                                            Notification::make()->title('Error de Conexión')->body($errorMessage)->danger()->send();
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()->title('Error de Sistema')->body($e->getMessage())->danger()->send();
                                    }
                                })
                        ])->alignCenter(),
                    ])
            ]);
    }
    
    public function save(): void
    {
        $newApiKey = $this->data['api_key'] ?? '';
        $this->updateEnvFile('GEMINI_API_KEY', $newApiKey);

        Notification::make()
            ->title('Guardado')
            ->body('La clave API ha sido actualizada en el archivo .env.')
            ->success()
            ->send();
        
        // Limpiamos la caché de configuración para que el cambio se refleje
        Artisan::call('config:clear');
    }
    
    private function updateEnvFile(string $key, string $value): void
    {
        $envFilePath = base_path('.env');
        
        // Si el valor contiene espacios o #, lo rodeamos con comillas
        if (preg_match('/\s|#/', $value)) {
            $value = '"' . $value . '"';
        }
        
        $newEntry = $key . '=' . $value;
        
        if (file_exists($envFilePath)) {
            $content = file_get_contents($envFilePath);
            
            if (preg_match('/^' . preg_quote($key, '/') . '.*/m', $content)) {
                $content = preg_replace('/^' . preg_quote($key, '/') . '.*/m', $newEntry, $content);
            } else {
                $content .= "\n" . $newEntry;
            }
            file_put_contents($envFilePath, $content);
        } else {
            file_put_contents($envFilePath, $newEntry . "\n");
        }
    }
}
