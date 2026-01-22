<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopCategoryResource\Pages;
use App\Models\TopCategory;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Section;

class TopCategoryResource extends Resource
{
    protected static ?string $model = TopCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string $navigationGroup = 'Home';
    protected static ?string $modelLabel = 'Categoría Top';
    protected static ?string $pluralModelLabel = 'Categorías Top';
    protected static ?string $navigationLabel = 'Categorías Top';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Asignar Categoría Top')
                    ->description('Selecciona una categoría y asígnale una prioridad para que aparezca en la sección de categorías destacadas de la página principal.')
                    ->schema([
                        // Columna izquierda para los campos
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label('Categoría')
                                    ->helperText('Elige la categoría que quieres destacar en la página principal.')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live(),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Prioridad')
                                    ->helperText('Un número más bajo indica mayor prioridad (aparece primero).')
                                    ->required()
                                    ->numeric(),
                            ])->columnSpan(1),

                        // Columna derecha para la previsualización de la imagen
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Placeholder::make('image_preview')
                                    ->label('Previsualización de la Imagen')
                                    ->content(function (Get $get): ?HtmlString {
                                        $categoryId = $get('category_id');
                                        if (!$categoryId) {
                                            return new HtmlString('<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #9ca3af; text-align: center; border: 2px dashed #d1d5db; border-radius: 0.5rem; padding: 2rem;">Selecciona una categoría para ver su imagen.</div>');
                                        }

                                        $category = Category::find($categoryId);
                                        if (!$category || !$category->image_path) {
                                            return new HtmlString('<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #9ca3af; text-align: center; border: 2px dashed #d1d5db; border-radius: 0.5rem; padding: 2rem;">La categoría seleccionada no tiene una imagen asignada.</div>');
                                        }

                                        $url = Storage::disk('public')->url($category->image_path);
                                        return new HtmlString('<img src="' . e($url) . '" style="height: 12rem; width: 100%; object-fit: cover; border-radius: 0.5rem;" alt="Imagen de la categoría">');
                                    })
                            ])->columnSpan(1),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('category.image_path')
                    ->label('Imagen')
                    ->height(80),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Prioridad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
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
            'index' => Pages\ListTopCategories::route('/'),
        ];
    }
}
