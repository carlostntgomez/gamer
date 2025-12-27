<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $navigationLabel = 'Ajustes del Sitio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Redes Sociales')
                    ->description('URLs de las redes sociales de la empresa.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('facebook_url')
                                ->label('Facebook')
                                ->url(),
                            TextInput::make('instagram_url')
                                ->label('Instagram')
                                ->url(),
                            TextInput::make('twitter_url')
                                ->label('Twitter / X')
                                ->url(),
                        ]),
                    ]),
                Section::make('Información de Contacto')
                    ->description('Teléfono y correo electrónico de contacto.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('phone')
                                ->label('Teléfono')
                                ->tel(),
                            TextInput::make('email')
                                ->label('Email')
                                ->email(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
        ];
    }
}
