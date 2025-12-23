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
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationLabel = 'Productos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Actions::make([
                Action::make('generateContent')
                    ->label('Generar Contenido con IA')
                    ->icon('heroicon-o-sparkles')
                    ->color('primary')
                    ->action(function (Forms\Set $set, Forms\Get $get) {
                        $apiKey = config('gemini.api_key');
                        $productName = $get('name');

                        if (empty($apiKey)) {
                            Notification::make()->title('Error')->body('La clave API de Gemini no está configurada.')->danger()->send();
                            return;
                        }

                        if (empty($productName)) {
                            Notification::make()->title('Error')->body('Por favor, introduce el nombre del producto.')->danger()->send();
                            return;
                        }

                        $prompt = <<<PROMPT
Actúa como un Copywriter Senior y Estratega SEO para TecnnyGames, una tienda online líder en el sector gaming.
Tu objetivo es crear contenido que no solo sea atractivo y persuasivo para nuestro público (gamers, entusiastas de la tecnología y coleccionistas), sino que también esté optimizado para los motores de búsqueda y maximice nuestra visibilidad.

Basándote EXCLUSIVAMENTE en el nombre del producto, genera el siguiente contenido:
Producto: {$productName}
PROMPT;

                        $schema = [
                            'type' => 'OBJECT',
                            'properties' => [
                                'short_description' => ['type' => 'STRING', 'description' => 'Un párrafo conciso y atractivo (máx 255 chars) que resuma los puntos fuertes del producto. Ideal para listados y vistas previas.'],
                                'long_description' => ['type' => 'STRING', 'description' => 'Una descripción MUY EXTENSA y detallada en formato HTML. Usa encabezados (<h3>), listas con viñetas (<ul><li>) y negritas (<strong>) para estructurar la información. Debe ser tan completa como sea posible, cubriendo características, beneficios, especificaciones técnicas (si aplica), y por qué es una compra ideal para un gamer. El objetivo es resolver todas las posibles dudas del cliente y persuadirlo a comprar.'],
                                'seo_title' => ['type' => 'STRING', 'description' => 'Título SEO optimizado, atractivo y que incluya la palabra clave principal. Debe incitar al clic. MUY IMPORTANTE: Límite estricto de 60 caracteres.'],
                                'seo_description' => ['type' => 'STRING', 'description' => 'Meta descripción SEO persuasiva. Incluye la palabra clave principal y un llamado a la acción. Debe destacar el beneficio principal para el usuario. MUY IMPORTANTE: Límite estricto de 160 caracteres.'],
                                'seo_keywords' => ['type' => 'STRING', 'description' => 'Una lista de 7 a 10 palabras clave y términos de búsqueda relevantes (long-tail y short-tail), separadas por comas. Piensa en cómo buscaría este producto un cliente.'],
                            ],
                            'required' => ['short_description', 'long_description', 'seo_title', 'seo_description', 'seo_keywords']
                        ];

                        try {
                            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey, [
                                    'contents' => [
                                        ['parts' => [
                                            ['text' => $prompt]
                                        ]]
                                    ],
                                    'generationConfig' => [
                                        'response_mime_type' => 'application/json',
                                        'response_schema' => $schema,
                                    ]
                                ]);

                            if ($response->successful()) {
                                $generatedContent = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                                $contentJson = json_decode($generatedContent, true);

                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $set('short_description', $contentJson['short_description'] ?? null);
                                    $set('long_description', $contentJson['long_description'] ?? null);
                                    $set('seo_title', $contentJson['seo_title'] ?? null);
                                    
                                    $seoDescription = $contentJson['seo_description'] ?? '';
                                    if (mb_strlen($seoDescription) > 160) {
                                        $truncated = mb_substr($seoDescription, 0, 157);
                                        // Find the last space to avoid breaking words
                                        $lastSpace = mb_strrpos($truncated, ' ');
                                        if ($lastSpace !== false) {
                                            $truncated = mb_substr($truncated, 0, $lastSpace);
                                        }
                                        $seoDescription = $truncated . '...';
                                    }
                                    $set('seo_description', $seoDescription);
                                    
                                    $keywords = $contentJson['seo_keywords'] ?? '';
                                    $set('seo_keywords', !is_array($keywords) ? array_map('trim', explode(',', $keywords)) : $keywords);

                                    Notification::make()->title('¡Éxito!')->body('El contenido ha sido generado y los campos han sido actualizados.')->success()->send();
                                } else {
                                    Notification::make()->title('Error de IA')->body('La IA no devolvió un JSON válido. Respuesta: ' . $generatedContent)->danger()->send();
                                }
                            } else {
                                $errorBody = $response->json();
                                $errorMessage = $errorBody['error']['message'] ?? 'Error desconocido al conectar con la API.';
                                Notification::make()->title('Error de API')->body($errorMessage)->danger()->send();
                            }
                        } catch (\Exception $e) {
                            Notification::make()->title('Error de Sistema')->body($e->getMessage())->danger()->send();
                        }
                    })
            ])->columnSpanFull(),
            Tabs::make('ProductTabs')->tabs([
                Tabs\Tab::make('Principal')
                    ->icon('heroicon-o-clipboard-document')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre del Producto')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state, ?string $old) {
                                if (!$state) { return; }
                                $set('seo_title', $state);
                                
                                $currentSlug = $get('slug');
                                $expectedOldSlug = Str::slug($old ?? '');

                                if (empty($currentSlug) || $currentSlug === $expectedOldSlug) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(Product::class, 'slug', ignoreRecord: true)
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                            ->helperText('URL amigable. Se genera del nombre, pero puedes editarla manualmente.'),

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

                        Textarea::make('short_description')
                            ->label('Descripción Corta')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Un resumen breve para listados y vistas previas.'),

                        RichEditor::make('long_description')
                            ->label('Descripción Larga')
                            ->columnSpanFull(),
                    ])->columns(2),

                Tabs\Tab::make('Detalles y Stock')
                    ->icon('heroicon-o-archive-box')
                    ->schema([
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU (Stock Keeping Unit)')
                            ->unique(Product::class, 'sku', ignoreRecord: true)
                            ->helperText('Código único para identificar el producto. Ej: CAM-ROJ-L-001'),

                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('Cantidad en Stock')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Cantidad de unidades disponibles.'),

                        Forms\Components\Select::make('type')
                            ->options(ProductType::class)
                            ->required()
                            ->label('Tipo de Producto'),

                        Forms\Components\Select::make('condition')
                            ->options(ProductCondition::class)
                            ->required()
                            ->label('Condición'),

                        Forms\Components\TagsInput::make('colors')
                            ->label('Colores Disponibles')
                            ->placeholder('Añadir color')
                            ->columnSpanFull(),
                    ])->columns(2),

                Tabs\Tab::make('Precios y Estado')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Precio Base')
                            ->required()
                            ->numeric()
                            ->prefix('COP'),

                        Forms\Components\TextInput::make('sale_price')
                            ->label('Precio de Oferta')
                            ->numeric()
                            ->prefix('COP')
                            ->helperText('Opcional. Mostrará un descuento.'),

                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visible en la tienda')
                            ->default(true)
                            ->helperText('Desactívalo para ocultar el producto.'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Producto Destacado')
                            ->helperText('Promociona este producto en la página principal.'),

                        Forms\Components\Toggle::make('is_new')
                            ->label('Marcar como Nuevo')
                            ->helperText('Añade una insignia de \'Nuevo\'.'),
                    ])->columns(2),

                Tabs\Tab::make('Multimedia')
                    ->icon('heroicon-o-photo')
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
                            ->helperText('Imágenes adicionales para mostrar detalles.')
                            ->getUploadedFileNameForStorageUsing(self::getFileName()),
                    ])->columns(1),

                Tabs\Tab::make('SEO')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(60)
                            ->helperText('Recomendado: Máximo 60 caracteres. Se autocompleta con el nombre del producto.'),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('Descripción SEO')
                            ->maxLength(160)
                            ->rows(3)
                            ->live(onBlur: true) // Added live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) { // Added afterStateUpdated
                                if ($state && mb_strlen($state) > 160) {
                                    $truncated = mb_substr($state, 0, 157);
                                    // Find the last space to avoid breaking words
                                    $lastSpace = mb_strrpos($truncated, ' ');
                                    if ($lastSpace !== false) {
                                        $truncated = mb_substr($truncated, 0, $lastSpace);
                                    }
                                    $set('seo_description', $truncated . '...');
                                }
                            })
                            ->helperText('Recomendado: Máximo 160 caracteres. Un resumen para Google.'),

                        Forms\Components\TagsInput::make('seo_keywords')
                            ->label('Palabras Clave SEO')
                            ->placeholder('Añadir etiqueta'),
                    ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image_path')->label('Imagen')->disk('public')->defaultImageUrl(url('/images/product-placeholder.png'))->square(),

                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('brand.name')->label('Marca')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('categories.name')->label('Categorías')->badge(),

                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (Product $record) {
                        $price = number_format($record->price, 0, ',', '.');
                        if ($record->sale_price && $record->sale_price < $record->price) {
                            $salePrice = number_format($record->sale_price, 0, ',', '.');
                            return "<s class='text-gray-500'>$ {$price}</s><br><strong class='text-primary-600'>$ {$salePrice}</strong>";
                        }
                        return "$ {$price}";
                    }),

                ToggleColumn::make('is_visible')->label('Visible'),

                ToggleColumn::make('is_featured')->label('Destacado'),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    { return [ RelationManagers\ReviewsRelationManager::class ]; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }

    private static function getFileName(): callable
    {
        return function (TemporaryUploadedFile $file): string {
            $originalName = $file->getClientOriginalName();
            $slug = str(pathinfo($originalName, PATHINFO_FILENAME))->slug();
            return (string) $slug->append('-' . uniqid() . '.webp');
        };
    }
}