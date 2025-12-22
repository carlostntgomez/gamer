<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeminiApiKeyResource\Pages;
use App\Models\GeminiApiKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class GeminiApiKeyResource extends Resource
{
    protected static ?string $model = GeminiApiKey::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Clave API de Gemini';
    protected static ?string $pluralModelLabel = 'Clave API de Gemini';
    protected static ?string $navigationLabel = 'Clave API de Gemini';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Clave API de Gemini')
                    ->description('Introduce tu clave API de Gemini para la integración con servicios de IA.')
                    ->schema([
                        TextInput::make('api_key')
                            ->label('Clave API')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => trim($state))
                            ->revealable()
                            ->maxLength(255)
                            ->helperText('Mantén esta clave segura. Se usará para acceder a los servicios de Gemini.'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('api_key')
                    ->label('Estado de la Clave')
                    ->formatStateUsing(fn ($state) => $state ? 'Establecida' : 'No establecida')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeminiApiKeys::route('/'),
        ];
    }

    public static function getSingleRecord(): Model
    {
        return GeminiApiKey::firstOrCreate([], ['api_key' => null]);
    }
}
