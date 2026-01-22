<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ToggleColumn;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Home';
    protected static ?string $modelLabel = 'Oferta';
    protected static ?string $pluralModelLabel = 'Ofertas';
    protected static ?string $navigationLabel = 'Ofertas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Contenido Principal')->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(255)
                        ->helperText('El texto principal que capta la atención en la oferta.'),
                    Forms\Components\TextInput::make('subtitle')
                        ->label('Subtítulo')
                        ->maxLength(255)
                        ->helperText('Un texto secundario que complementa o describe la oferta.'),
                ])->columnSpan(2),

                Section::make('Imagen de la Oferta')->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Imagen')
                        ->required()
                        ->image()
                        ->rules(['dimensions:min_width=960,min_height=600'])
                        ->validationMessages([
                            'dimensions' => 'La imagen debe tener un tamaño mínimo de 960x600 píxeles para poder recortarla.',
                        ])
                        ->helperText('Resolución obligatoria: 960x600px. La imagen se recortará a esta proporción.')
                        ->imageEditor()
                        ->imageEditorAspectRatios(['960:600'])
                        ->imageEditorViewportWidth('960')
                        ->imageEditorViewportHeight('600')
                        ->disk('public')
                        ->directory('temp-uploads'),
                ])->columnSpan(2),

                Section::make('Llamada a la Acción (CTA)')->schema([
                    Forms\Components\TextInput::make('cta_text')
                        ->label('Texto del Botón (CTA)')
                        ->required()
                        ->maxLength(255)
                        ->helperText('El texto que se mostrará dentro del botón (ej. "Comprar Ahora", "Ver Oferta").'),
                    Forms\Components\TextInput::make('cta_link')
                        ->label('Enlace del Botón (CTA)')
                        ->required()
                        ->maxLength(255)
                        ->helperText('La URL a la que redirigirá el botón (ej. "/productos/descuentos").'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Activo')
                        ->required()
                        ->helperText('Controla si esta oferta se muestra en la página principal.'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtítulo')
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Activo'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
        ];
    }
}
