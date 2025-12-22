<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Ajuste';
    protected static ?string $pluralModelLabel = 'Ajustes Generales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información General del Sitio')
                    ->description('Configura los detalles básicos de tu sitio web.')
                    ->schema([
                        TextInput::make('site_name')->label('Nombre del Sitio')->maxLength(255)->nullable(),
                        TextInput::make('site_slogan')->label('Eslogan del Sitio')->maxLength(255)->nullable(),
                        TextInput::make('copyright_text')->label('Texto de Copyright')->maxLength(255)->nullable(),
                    ])->columns(2),

                Section::make('Información de Contacto')
                    ->description('Datos de contacto que se mostrarán en el sitio.')
                    ->schema([
                        TextInput::make('contact_email')->label('Correo Electrónico')->email()->maxLength(255)->nullable(),
                        TextInput::make('contact_phone')->label('Teléfono')->tel()->maxLength(255)->nullable(),
                        Textarea::make('address')->label('Dirección')->rows(3)->maxLength(65535)->nullable(),
                    ])->columns(2),

                Section::make('Redes Sociales')
                    ->description('Añade enlaces a tus perfiles de redes sociales.')
                    ->schema([
                        KeyValue::make('social_links')
                            ->label('Enlaces Sociales')
                            ->keyLabel('Plataforma (ej: Facebook, Twitter, Instagram)')
                            ->valueLabel('URL del Perfil')
                            ->addActionLabel('Añadir nuevo enlace')
                            ->helperText('Asegúrate de que las URLs son completas, incluyendo https://')
                            ->nullable(),
                    ]),

                Section::make('Identidad Visual')
                    ->description('Sube el logo y el favicon para tu sitio.')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->disk('public')
                            ->directory('settings')
                            ->image()
                            ->maxSize(1024)
                            ->helperText('Sube el logo principal. Se recomienda un archivo PNG transparente.')
                            ->nullable(),
                        FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->disk('public')
                            ->directory('settings')
                            ->image()
                            ->imageEditor()
                            ->maxSize(512)
                            ->helperText('Sube el icono del sitio (favicon). Se recomienda un tamaño de 32x32px.')
                            ->nullable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                TextColumn::make('site_name')->label('Nombre del Sitio'),
                TextColumn::make('updated_at')->label('Última Modificación')->dateTime()->sortable(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
        ];
    }
}
