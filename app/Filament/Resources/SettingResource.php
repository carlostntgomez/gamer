<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Illuminate\Support\Facades\Storage;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 10;
    protected static ?string $modelLabel = 'Configuración';
    protected static ?string $pluralModelLabel = 'Configuración';
    protected static ?string $navigationLabel = 'Ajustes Generales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información General del Sitio')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Nombre del Sitio')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\TextInput::make('site_slogan')
                                    ->label('Eslogan del Sitio')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Correo Electrónico de Contacto')
                                    ->email()
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('Teléfono de Contacto')
                                    ->tel()
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Textarea::make('address')
                                    ->label('Dirección')
                                    ->rows(3)
                                    ->maxLength(65535)
                                    ->nullable(),
                                Forms\Components\TextInput::make('copyright_text')
                                    ->label('Texto de Copyright')
                                    ->maxLength(255)
                                    ->nullable(),
                            ])->columns(2),

                        Forms\Components\Section::make('Redes Sociales')
                            ->schema([
                                KeyValue::make('social_links')
                                    ->label('Enlaces a Redes Sociales')
                                    ->keyLabel('Plataforma (ej: facebook, twitter)')
                                    ->valueLabel('URL')
                                    ->addActionLabel('Añadir Enlace')
                                    ->nullable(),
                            ]),

                        Forms\Components\Section::make('Logos e Iconos')
                            ->schema([
                                FileUpload::make('logo_path')
                                    ->label('Logo del Sitio')
                                    ->disk('public')
                                    ->directory('settings')
                                    ->visibility('public')
                                    ->image()
                                    ->maxSize(1024) // 1MB
                                    ->nullable(),
                                FileUpload::make('favicon_path')
                                    ->label('Favicon del Sitio')
                                    ->disk('public')
                                    ->directory('settings')
                                    ->visibility('public')
                                    ->image()
                                    ->maxSize(512) // 512KB
                                    ->nullable(),
                            ])->columns(2),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        // This method will not be used as we redirect directly to the edit page.
        // However, Filament requires it, so return an empty table.
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')
                    ->label('Nombre del Sitio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Correo de Contacto'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->color('primary'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            // 'create' => Pages\CreateSetting::route('/create'), // Disable create as only one record should exist
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}

