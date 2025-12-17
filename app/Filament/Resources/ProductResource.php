<?php

namespace App\Filament\Resources;

use App\Enums\ProductCondition;
use App\Enums\ProductType;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationLabel = 'Productos';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información del Producto')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Product::class, 'slug', ignoreRecord: true),

                                Forms\Components\MarkdownEditor::make('description')
                                    ->label('Descripción')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Imágenes')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('product-images')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->reorderable()
                                    ->image()
                                    ->label('Galería de Imágenes'),
                            ]),

                        Forms\Components\Section::make('Precios')
                            ->schema([
                                Forms\Components\TextInput::make('price')->label('Precio')->required()->numeric()->prefix('USD'),
                                Forms\Components\TextInput::make('sale_price')->label('Precio de Oferta')->numeric()->prefix('USD'),
                                Forms\Components\TextInput::make('sku')->label('SKU (Stock Keeping Unit)')->unique(Product::class, 'sku', ignoreRecord: true),
                            ])->columns(3),
                        
                        Forms\Components\Section::make('Inventario')
                            ->schema([
                                Forms\Components\TextInput::make('stock')->required()->numeric()->default(0),
                            ]),

                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Estado')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')->label('Producto Destacado'),
                            ]),

                        Forms\Components\Section::make('Organización')
                            ->schema([
                                Forms\Components\Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->required()
                                    ->label('Marca'),

                                Forms\Components\Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->required()
                                    ->label('Categorías'),
                            ]),

                        Forms\Components\Section::make('Atributos')
                            ->schema([
                                Forms\Components\Select::make('type')->options(ProductType::class)->required()->label('Tipo'),
                                Forms\Components\Select::make('condition')->options(ProductCondition::class)->required()->label('Condición'),
                                Forms\Components\TagsInput::make('colors')->label('Colores'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('media')
                    ->collection('product-images')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('brand.name')->label('Marca')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Precio')->money('usd')->sortable(),
                Tables\Columns\TextColumn::make('stock')->label('Stock')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Destacado')->boolean(),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Actualizado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name')
                    ->label('Marca'),
                Tables\Filters\SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->label('Categoría'),
                Tables\Filters\Filter::make('is_featured')
                    ->query(fn ($query) => $query->where('is_featured', true))
                    ->label('Solo Destacados'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
                Tables\Actions\EditAction::make()->iconButton()->color('primary'),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
        ];
    }
}
