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
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationLabel = 'Productos';
    protected static ?int $navigationSort = 1; // Prioridad alta

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Información Principal del Producto')
                        ->description('Introduce el nombre, slug y descripción. El SEO se autocompletará inicialmente.')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre del Producto')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                    $set('slug', Str::slug($state));
                                    $set('seo_title', $state); // Auto-rellenar Título SEO
                                }),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Product::class, 'slug', ignoreRecord: true)
                                ->disabled(fn (string $operation): bool => $operation === 'edit')
                                ->helperText('URL amigable. Se recomienda no cambiarla una vez creada.'),

                            Forms\Components\MarkdownEditor::make('description')
                                ->label('Descripción Detallada')
                                ->columnSpanFull(),
                        ])->columns(2),

                    Forms\Components\Section::make('Imágenes del Producto')
                        ->description('Sube la imagen principal y una galería de imágenes adicionales.')
                        ->collapsible()
                        ->schema([
                            FileUpload::make('main_image_path')
                                ->label('Imagen Principal')
                                ->directory('products')->disk('public')->image()->imageEditor()
                                ->required()
                                ->helperText('La primera imagen que verán los clientes.')
                                ->getUploadedFileNameForStorageUsing(self::getFileName()),

                            FileUpload::make('gallery_image_paths')
                                ->label('Galería de Imágenes')
                                ->directory('products')->disk('public')->image()->imageEditor()->multiple()
                                ->helperText('Imágenes adicionales para mostrar detalles del producto.')
                                ->getUploadedFileNameForStorageUsing(self::getFileName()),
                        ]),

                    Forms\Components\Section::make('Precios')
                        ->description('Define el costo del producto y ofertas especiales.')
                        ->schema([
                            Forms\Components\TextInput::make('price')->label('Precio Base')->required()->numeric()->prefix('COP'),
                            Forms\Components\TextInput::make('sale_price')->label('Precio de Oferta')->numeric()->prefix('COP')->helperText('Opcional. Mostrará un descuento si es menor al precio base.'),
                        ])->columns(2),

                    Forms\Components\Section::make('Inventario y SKU')
                        ->description('Gestiona el stock y el identificador único de tu producto.')
                        ->schema([
                            Forms\Components\TextInput::make('sku')->label('SKU (Stock Keeping Unit)')->unique(Product::class, 'sku', ignoreRecord: true)->helperText('Código único para identificar el producto. Ej: CAM-ROJ-L-001'),
                            Forms\Components\TextInput::make('stock_quantity')->label('Cantidad en Stock')->required()->numeric()->default(0)->helperText('La cantidad de unidades disponibles para la venta.'),
                        ])->columns(2),

                ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Estado y Visibilidad')
                        ->description('Controla si el producto es visible, destacado, etc.')
                        ->schema([
                            Forms\Components\Toggle::make('is_visible')->label('Visible en la tienda')->default(true)->helperText('Desactívalo para ocultar el producto temporalmente.'),
                            Forms\Components\Toggle::make('is_featured')->label('Producto Destacado')->helperText('Promociona este producto en la página principal.'),
                            Forms\Components\Toggle::make('is_new')->label('Marcar como Nuevo')->helperText('Añade una insignia de \'Nuevo\' al producto.'),
                        ]),

                    Forms\Components\Section::make('Organización')
                        ->description('Asigna el producto a marcas y categorías.')
                        ->schema([
                            Forms\Components\Select::make('brand_id')->relationship('brand', 'name')->searchable()->required()->label('Marca'),
                            Forms\Components\Select::make('categories')->relationship('categories', 'name')->multiple()->searchable()->required()->label('Categorías'),
                        ]),

                    Forms\Components\Section::make('Atributos del Producto')
                        ->description('Define características específicas del producto.')
                        ->schema([
                            Forms\Components\Select::make('type')->options(ProductType::class)->required()->label('Tipo de Producto'),
                            Forms\Components\Select::make('condition')->options(ProductCondition::class)->required()->label('Condición'),
                            Forms\Components\TagsInput::make('colors')->label('Colores Disponibles')->placeholder('Añadir color'),
                        ]),
                    
                    Forms\Components\Section::make('Optimización para Motores de Búsqueda (SEO)')
                        ->description('Mejora la visibilidad de este producto en Google.')
                        ->collapsible()
                        ->schema([
                            Forms\Components\TextInput::make('seo_title')->label('Título SEO')->maxLength(60)->helperText('Máx. 60 caracteres.'),
                            Forms\Components\Textarea::make('seo_description')->label('Descripción SEO')->maxLength(160)->rows(3)->helperText('Máx. 160 caracteres.'),
                            Forms\Components\TagsInput::make('seo_keywords')->label('Palabras Clave SEO')->placeholder('Añadir etiqueta'),
                        ]),
                ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image_path')->label('Imagen')->disk('public')->defaultImageUrl(url('/images/product-placeholder.png'))->square(),
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('brand.name')->label('Marca')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Precio')->money('cop')->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')->label('Stock')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_visible')->label('Visible')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Destacado')->boolean(),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->searchable()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name')->label('Marca'),
                Tables\Filters\SelectFilter::make('categories')->relationship('categories', 'name')->label('Categoría'),
                Tables\Filters\Filter::make('is_featured')->query(fn ($query) => $query->where('is_featured', true))->label('Solo Destacados'),
                Tables\Filters\Filter::make('is_visible')->query(fn ($query) => $query->where('is_visible', true))->label('Solo Visibles'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_public')
                    ->label('Ver en Web')
                    ->url(fn (Product $record): string => route('product.show', ['slug' => $record->slug]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->iconButton(),
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
                Tables\Actions\EditAction::make()->iconButton()->color('primary'),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    { return [ RelationManagers\ReviewsRelationManager::class ]; }

    public static function getPages(): array
    { return [ 'index' => Pages\ManageProducts::route('/') ]; }

    private static function getFileName(): callable
    {
        return function (TemporaryUploadedFile $file): string {
            $originalName = $file->getClientOriginalName();
            $slug = str(pathinfo($originalName, PATHINFO_FILENAME))->slug();
            return (string) $slug->append('-' . uniqid() . '.webp');
        };
    }
}
