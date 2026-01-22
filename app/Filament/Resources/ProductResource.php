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
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Http\Client\Response;
use Filament\Tables\Columns\IconColumn;

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
                FormAction::make('generateContent')
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

**REGLAS CRÍTICAS e INQUEBRANTABLES:**
- Los límites de caracteres son ESTRICTOS. NUNCA, bajo ninguna circunstancia, debes excederlos.
- `seo_title`: MÁXIMO 60 caracteres.
- `seo_description`: MÁXIMO 160 caracteres.

Tu objetivo es crear contenido persuasivo y optimizado para SEO para nuestro público (gamers, entusiastas tech y coleccionistas).

Basándote EXCLUSIVAMENTE en el nombre del producto, genera el siguiente contenido:
Producto: {$productName}
PROMPT;

                        $schema = [
                            'type' => 'OBJECT',
                            'properties' => [
                                'short_description' => ['type' => 'STRING', 'description' => 'Un párrafo conciso y atractivo (máx 255 chars) que resuma los puntos fuertes del producto. Ideal para listados y vistas previas.'],
                                'long_description' => ['type' => 'STRING', 'description' => 'Una descripción de marketing, persuasiva y atractiva en formato HTML. Usa encabezados (<h3>), listas (<ul><li>) y negritas (<strong>) para estructurar la información. Céntrate en los BENEFICIOS y en por qué es una compra ideal para un gamer. NO incluyas especificaciones técnicas aquí.'],
                                'specifications' => ['type' => 'STRING', 'description' => 'Un string JSON con clave-valor para las especificaciones técnicas CLAVE del producto. Si el nombre del producto es específico (ej. "PlayStation 5", "Monitor Dell UltraSharp U2723QE"), la IA debe INFERIR las especificaciones más relevantes basándose en su conocimiento general. Si el producto es genérico o no hay especificaciones claras que inferir, o si no son necesarias (ej. una camiseta), devuelve un string con un objeto JSON vacío, como "{}"'],
                                'seo_title' => ['type' => 'STRING', 'description' => 'Título SEO optimizado. REGLA ESTRICTA: NO DEBE SUPERAR los 60 caracteres. Es un límite MÁXIMO, no una sugerencia. Incluye la palabra clave principal y debe incitar al clic.'],
                                'seo_description' => ['type' => 'STRING', 'description' => 'Meta descripción SEO persuasiva. REGLA ESTRICTA: NO DEBE SUPERAR los 160 caracteres. Es un límite MÁXIMO, no una sugerencia. Incluye la palabra clave principal y un llamado a la acción.'],
                                'seo_keywords' => ['type' => 'STRING', 'description' => 'Una lista de 7 a 10 palabras clave y términos de búsqueda relevantes (long-tail y short-tail), separadas por comas.'],
                            ],
                            'required' => ['short_description', 'long_description', 'specifications', 'seo_title', 'seo_description', 'seo_keywords']
                        ];

                        try {
                            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey, [
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
                                    
                                    $specifications = json_decode($contentJson['specifications'] ?? '{}', true);
                                    $set('specifications', $specifications);

                                    $seoTitle = $contentJson['seo_title'] ?? '';
                                    $set('seo_title', mb_strlen($seoTitle) > 60 ? mb_substr($seoTitle, 0, 60) : $seoTitle);

                                    $seoDescription = $contentJson['seo_description'] ?? '';
                                    if (mb_strlen($seoDescription) > 160) {
                                        $truncated = mb_substr($seoDescription, 0, 157);
                                        $lastSpace = mb_strrpos($truncated, ' ');
                                        $seoDescription = ($lastSpace !== false) ? mb_substr($truncated, 0, $lastSpace) . '...' : $truncated . '...' ;
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
                Tabs\Tab::make('Principal')->icon('heroicon-o-clipboard-document')->schema([
                    Forms\Components\TextInput::make('name')->label('Nombre del Producto')->required()->maxLength(255)->live(onBlur: true)->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state, ?string $old) {
                        if (!$state) { return; }
                        $set('seo_title', $state);
                        $currentSlug = $get('slug');
                        $expectedOldSlug = Str::slug($old ?? '');
                        if (empty($currentSlug) || $currentSlug === $expectedOldSlug) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                    Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(Product::class, 'slug', ignoreRecord: true)->live()->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))->helperText('URL amigable. Se genera del nombre, pero puedes editarla manualmente.'),
                    Forms\Components\Select::make('brand_id')->relationship('brand', 'name')->searchable()->required()->label('Marca'),
                    Forms\Components\Select::make('categories')->relationship('categories', 'name')->multiple()->searchable()->required()->label('Categorías'),
                ])->columns(2),
                Tabs\Tab::make('Contenido')->icon('heroicon-o-pencil-square')->schema([
                    Forms\Components\Textarea::make('short_description')->label('Descripción Corta')->rows(3)->columnSpanFull()->helperText('Un resumen breve para listados y vistas previas.'),
                    Forms\Components\RichEditor::make('long_description')->label('Descripción Larga')->columnSpanFull(),
                    Forms\Components\KeyValue::make('specifications')->label('Especificaciones')->keyLabel('Característica')->valueLabel('Valor')->columnSpanFull()->helperText('Añade las especificaciones técnicas del producto.'),
                ]),
                Tabs\Tab::make('Detalles y Stock')->icon('heroicon-o-archive-box')->schema([
                    Forms\Components\TextInput::make('sku')->label('SKU (Stock Keeping Unit)')->unique(Product::class, 'sku', ignoreRecord: true)->helperText('Código único para identificar el producto. Ej: CAM-ROJ-L-001'),
                    Forms\Components\TextInput::make('stock_quantity')->label('Cantidad en Stock')->required()->numeric()->default(0)->helperText('Cantidad de unidades disponibles.'),
                    Forms\Components\Select::make('type')->options(ProductType::class)->required()->label('Tipo de Producto'),
                    Forms\Components\Select::make('condition')->options(ProductCondition::class)->required()->label('Condición'),
                    Forms\Components\TagsInput::make('colors')->label('Colores Disponibles')->placeholder('Añadir color')->columnSpanFull(),
                ])->columns(2),
                Tabs\Tab::make('Precios y Estado')->icon('heroicon-o-currency-dollar')->schema([
                    Forms\Components\TextInput::make('price')->label('Precio Base')->required()->numeric()->prefix('COP'),
                    Forms\Components\TextInput::make('sale_price')->label('Precio de Oferta')->numeric()->prefix('COP')->helperText('Opcional. Mostrará un descuento.'),
                    Forms\Components\Toggle::make('is_visible')->label('Visible en la tienda')->default(true)->helperText('Desactívalo para ocultar el producto.'),
                    Forms\Components\Toggle::make('is_featured')->label('Producto Destacado')->helperText('Promociona este producto en la página principal.'),
                    Forms\Components\Toggle::make('is_new')->label('Marcar como Nuevo')->helperText('Añade una insignia de \'Nuevo\'.'),
                ])->columns(2),
                Tabs\Tab::make('Multimedia')->icon('heroicon-o-photo')->schema([
                    Forms\Components\FileUpload::make('main_image_path')
                        ->label('Imagen Principal')
                        ->directory('temp-uploads')
                        ->disk('public')
                        ->image()
                        ->imageEditor()
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('800')
                        ->required()
                        ->columnSpanFull()
                        ->helperText('Obligatoria. El editor forzará un recorte a 800x800. La imagen se convertirá a WebP.'),
                    Forms\Components\FileUpload::make('gallery_image_paths')
                        ->label('Galería de Imágenes')
                        ->directory('temp-uploads')
                        ->disk('public')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->imageEditor()
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('800')
                        ->maxFiles(10)
                        ->columnSpanFull()
                        ->helperText('Opcional. Sube hasta 10 imágenes. Recorte a 800x800 y conversión a WebP.'),
                    Forms\Components\TextInput::make('video_url')->label('URL del Video de YouTube')->url()->helperText('Pega aquí la URL completa de un video de YouTube.'),
                ]),
                Tabs\Tab::make('SEO')->icon('heroicon-o-magnifying-glass')->schema([
                    Forms\Components\TextInput::make('seo_title')->label('Título SEO')->maxLength(60)->helperText('Recomendado: Máximo 60 caracteres. Se autocompleta con el nombre del producto.'),
                    Forms\Components\Textarea::make('seo_description')->label('Descripción SEO')->maxLength(160)->rows(3)->live(onBlur: true)->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                        $seoDescription = $state ?? '';
                        if (mb_strlen($seoDescription) > 160) {
                            $truncated = mb_substr($seoDescription, 0, 157);
                            $lastSpace = mb_strrpos($truncated, ' ');
                            $seoDescription = ($lastSpace !== false) ? mb_substr($truncated, 0, $lastSpace) . '...' : $truncated . '...' ;
                        }
                        $set('seo_description', $seoDescription);
                    })->helperText('Recomendado: Máximo 160 caracteres. Un resumen para Google.'),
                    Forms\Components\TagsInput::make('seo_keywords')->label('Palabras Clave SEO')->placeholder('Añadir etiqueta'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->defaultImageUrl(url('/images/product-placeholder.png'))
                    ->square()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Product $record): string => $record->sku ? "SKU: {$record->sku}" : 'SKU no definido')
                    ->wrap()
                    ->toggleable()
                    ->grow(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categorías')
                    ->badge()
                    ->color('primary')
                    ->toggleable()
                    ->limit(2)
                    ->wrap(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (Product $record) {
                        $price = number_format($record->price, 0, ',', '.');
                        if ($record->sale_price && $record->sale_price < $record->price) {
                            $salePrice = number_format($record->sale_price, 0, ',', '.');
                            return "<s class='text-gray-400'>$ {$price}</s><br><strong class='text-success-600'>$ {$salePrice}</strong>";
                        }
                        return "$ {$price}";
                    })
                    ->alignRight()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    })
                    ->alignCenter()
                    ->toggleable(),
                ToggleColumn::make('is_visible')
                    ->label('Visible')
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('is_featured')
                    ->label('Destacado')
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('is_new')
                    ->label('Nuevo')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categories')->relationship('categories', 'name')->label('Categoría'),
                Tables\Filters\Filter::make('is_featured')->query(fn ($query) => $query->where('is_featured', true))->label('Solo Destacados'),
                Tables\Filters\Filter::make('is_visible')->query(fn ($query) => $query->where('is_visible', true))->label('Solo Visibles'),
            ])
            ->actions([
                Tables\Actions\Action::make('viewPublic')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Product $record): string => route('shop.show', ['product' => $record]))
                    ->openUrlInNewTab()
                    ->color('success')
                    ->tooltip('Ver producto en la tienda')
                    ->iconButton(),
                Tables\Actions\ViewAction::make()->icon('heroicon-o-document-magnifying-glass')->color('gray')->tooltip('Ver detalles del producto')->iconButton(),
                Tables\Actions\EditAction::make()->icon('heroicon-o-pencil-square')->color('warning')->tooltip('Editar producto')->iconButton(),
                Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash')->color('danger')->tooltip('Eliminar producto')->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Imágenes del Producto')->schema([
                Infolists\Components\ImageEntry::make('main_image_path')
                    ->label('Imagen Principal')
                    ->hiddenLabel()
                    ->width('100%')
                    ->height('auto')
                    ->disk('public'),
                Infolists\Components\ImageEntry::make('gallery_image_paths')
                    ->label('Galería de Imágenes')
                    ->hiddenLabel()
                    ->width('100%')
                    ->height('auto')
                    ->disk('public'),
            ])->columnSpan(1),

            Infolists\Components\Group::make([
                Infolists\Components\Section::make('Información del Producto')->schema([
                    Infolists\Components\TextEntry::make('name')->label('Nombre')->weight('bold')->size('lg'),
                    Infolists\Components\TextEntry::make('slug')->label('URL Slug')->icon('heroicon-o-link'),
                    Infolists\Components\TextEntry::make('brand.name')->label('Marca')->badge(),
                    Infolists\Components\TextEntry::make('categories.name')->label('Categorías')->badge(),
                    Infolists\Components\TextEntry::make('colors')->label('Colores')->badge(),
                ])->columns(2),

                Infolists\Components\Section::make('Estado y Visibilidad')->schema([
                    Infolists\Components\IconEntry::make('is_visible')->label('Visibilidad')->boolean(),
                    Infolists\Components\IconEntry::make('is_featured')->label('Destacado')->boolean(),
                    Infolists\Components\IconEntry::make('is_new')->label('Nuevo')->boolean(),
                ])->columns(3),

                Infolists\Components\Section::make('Precios y Stock')->schema([
                    Infolists\Components\TextEntry::make('price')->label('Precio Base')->money('cop')->weight('semibold'),
                    Infolists\Components\TextEntry::make('sale_price')->label('Precio de Oferta')->money('cop')->weight('semibold')->color('success'),
                    Infolists\Components\TextEntry::make('stock_quantity')->label('Stock')->badge(),
                    Infolists\Components\TextEntry::make('sku')->label('SKU'),
                    Infolists\Components\TextEntry::make('type')->label('Tipo')->badge(),
                    Infolists\Components\TextEntry::make('condition')->label('Condición')->badge(),
                ])->columns(3),

                Infolists\Components\Section::make('Descripciones')->schema([
                    Infolists\Components\TextEntry::make('short_description')->label('Descripción Corta')->columnSpanFull(),
                    Infolists\Components\TextEntry::make('long_description')->label('Descripción Larga')->html()->columnSpanFull(),
                    Infolists\Components\ViewEntry::make('specifications')->view('infolists.components.key-value-entry'),
                ])->collapsible(),

                Infolists\Components\Section::make('SEO')->schema([
                    Infolists\Components\TextEntry::make('seo_title')->label('Título SEO'),
                    Infolists\Components\TextEntry::make('seo_description')->label('Descripción SEO'),
                    Infolists\Components\TextEntry::make('seo_keywords')->label('Palabras Clave')->badge(),
                ])->columns(2)->collapsible(),
            ])->columnSpan(2),
        ])->columns(3);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
        ];
    }
    
    public static function getModalWidth(): string
    {
        return '6xl';
    }
}
