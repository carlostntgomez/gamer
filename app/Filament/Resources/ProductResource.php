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
                    ->action(function (Forms\Set $set, Forms\Get $get, string $operation) {
                        $apiKey = config('gemini.api_key');
                        $imagePath = $get('main_image_path');
                        $productName = $get('name');

                        if (empty($apiKey)) {
                            Notification::make()->title('Error')->body('La clave API de Gemini no está configurada.')->danger()->send();
                            return;
                        }

                        if (empty($imagePath)) {
                            Notification::make()->title('Error')->body('Por favor, sube una imagen principal primero.')->danger()->send();
                            return;
                        }

                        if (empty($productName)) {
                            Notification::make()->title('Error')->body('Por favor, introduce el nombre del producto.')->danger()->send();
                            return;
                        }

                        $imageData = null;
                        $mimeType = null;
                        $imageFile = $imagePath[0];

                        if ($operation === 'create') {
                            if (!$imageFile instanceof TemporaryUploadedFile) {
                                Notification::make()->title('Error de Imagen')->body('Ocurrió un error con el archivo de imagen. Intenta subirlo de nuevo.')->danger()->send();
                                return;
                            }
                            $imageData = file_get_contents($imageFile->getRealPath());
                            $mimeType = $imageFile->getMimeType();
                        } else { // edit
                            if (!is_string($imageFile) || !Storage::disk('public')->exists($imageFile)) {
                                Notification::make()->title('Error de Imagen')->body('El archivo de la imagen no se encuentra o la ruta no es válida.')->danger()->send();
                                return;
                            }
                            $imageData = Storage::disk('public')->get($imageFile);
                            $mimeType = Storage::disk('public')->mimeType($imageFile);
                        }

                        $prompt = 'Eres un experto en e-commerce y SEO para una tienda de temática gaming. Basándote en la imagen del producto y su nombre, genera el siguiente contenido en español. El nombre del producto es \'' . $productName . '\'. Quiero una respuesta en formato JSON con las siguientes claves: short_description (máximo 255 caracteres), long_description (descripción detallada en HTML), seo_title (máximo 60 caracteres), seo_description (máximo 160 caracteres), seo_keywords (una lista de 5-7 palabras clave separadas por comas).';

                        try {
                            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey, [
                                    'contents' => [
                                        [
                                            'parts' => [
                                                ['text' => $prompt],
                                                ['inline_data' => [
                                                    'mime_type' => $mimeType,
                                                    'data' => base64_encode($imageData)
                                                ]]
                                            ]
                                        ]
                                    ],
                                    'generationConfig' => [
                                        'response_mime_type' => 'application/json',
                                    ]
                                ]);

                            if ($response->successful()) {
                                $generatedContent = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                                $contentJson = json_decode($generatedContent, true);

                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $set('short_description', $contentJson['short_description'] ?? null);
                                    $set('long_description', $contentJson['long_description'] ?? null);
                                    $set('seo_title', $contentJson['seo_title'] ?? null);
                                    $set('seo_description', $contentJson['seo_description'] ?? null);
                                    $set('seo_keywords', isset($contentJson['seo_keywords']) ? explode(',', trim($contentJson['seo_keywords'])) : []);

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
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                    $set('seo_title', $state);
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(Product::class, 'slug', ignoreRecord: true)
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->helperText('URL amigable (no cambiar una vez creada).'),

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
