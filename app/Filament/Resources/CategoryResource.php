<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Categoría';
    protected static ?string $pluralModelLabel = 'Categorías';
    protected static ?string $navigationLabel = 'Categorías';
    protected static ?int $navigationSort = 2;

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
                        $categoryName = $get('name');

                        if (empty($apiKey)) {
                            Notification::make()->title('Error')->body('La clave API de Gemini no está configurada.')->danger()->send();
                            return;
                        }

                        if (empty($categoryName)) {
                            Notification::make()->title('Error')->body('Por favor, introduce el nombre de la categoría.')->danger()->send();
                            return;
                        }

                        $prompt = <<<PROMPT
Actúa como un Copywriter Senior y Estratega SEO para TecnnyGames, una tienda online líder en el sector gaming.

**REGLAS CRÍTICAS e INQUEBRANTABLES:**
- Los límites de caracteres son ESTRICTOS. NUNCA, bajo ninguna circunstancia, debes excederlos.
- `seo_title`: MÁXIMO 60 caracteres.
- `seo_description`: MÁXIMO 160 caracteres.

Tu objetivo es crear contenido persuasivo y optimizado para SEO para nuestra audiencia de gamers y entusiastas de la tecnología.

Basándote EXCLUSIVAMENTE en el nombre de la categoría, genera el siguiente contenido:
Categoría: {$categoryName}
PROMPT;

                        $schema = [
                            'type' => 'OBJECT',
                            'properties' => [
                                'description' => ['type' => 'STRING', 'description' => 'Una descripción de marketing para la categoría, persuasiva y atractiva, en formato HTML. Usa encabezados (<h3>), listas (<ul><li>) y negritas (<strong>) para estructurar la información. Debe invitar a los usuarios a explorar los productos de esta categoría.'],
                                'seo_title' => ['type' => 'STRING', 'description' => 'Título SEO optimizado para la categoría. REGLA ESTRICTA: NO DEBE SUPERAR los 60 caracteres. Debe ser atractivo e incitar al clic.'],
                                'seo_description' => ['type' => 'STRING', 'description' => 'Meta descripción SEO persuasiva para la categoría. REGLA ESTRICTA: NO DEBE SUPERAR los 160 caracteres. Debe incluir la palabra clave principal y un llamado a la acción claro.'],
                                'seo_keywords' => ['type' => 'STRING', 'description' => 'Una lista de 5 a 7 palabras clave y términos de búsqueda relevantes (long-tail y short-tail) para esta categoría, separadas por comas.'],
                            ],
                            'required' => ['description', 'seo_title', 'seo_description', 'seo_keywords']
                        ];

                        try {
                            /** @var \Illuminate\Http\Client\Response $response */
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
                                    $set('description', $contentJson['description'] ?? null);
                                    
                                    $seoTitle = $contentJson['seo_title'] ?? '';
                                    $set('seo_title', mb_strlen($seoTitle) > 60 ? mb_substr($seoTitle, 0, 60) : $seoTitle);

                                    $seoDescription = $contentJson['seo_description'] ?? '';
                                    if (mb_strlen($seoDescription) > 160) {
                                        $truncated = mb_substr($seoDescription, 0, 157);
                                        $lastSpace = mb_strrpos($truncated, ' ');
                                        $seoDescription = ($lastSpace !== false) ? mb_substr($truncated, 0, $lastSpace) . '...' : $truncated . '...';
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
            Tabs::make('CategoryTabs')
                ->tabs([
                    Tabs\Tab::make('Información Principal')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
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
                                })
                                ->helperText('El nombre que se mostrará públicamente.'),

                            Forms\Components\Select::make('parent_id')
                                ->label('Categoría Padre')
                                ->relationship('parent', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Opcional: Asigna una categoría padre')
                                ->helperText('Crea una jerarquía de categorías (ej: Ropa > Camisetas).'),

                            Forms\Components\RichEditor::make('description')
                                ->label('Descripción de la Categoría')
                                ->nullable()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Tabs\Tab::make('Contenido SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Category::class, 'slug', ignoreRecord: true)
                                ->live()
                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                                ->helperText('URL amigable. Se genera del nombre, pero puedes editarla manualmente.'),

                            Forms\Components\TextInput::make('seo_title')
                                ->label('Título SEO')
                                ->maxLength(60)
                                ->nullable()
                                ->helperText('Recomendado: Máximo 60 caracteres. Es el título que aparece en Google.'),

                            Forms\Components\Textarea::make('seo_description')
                                ->label('Descripción SEO')
                                ->maxLength(160)
                                ->rows(3)
                                ->nullable()
                                ->helperText('Recomendado: Máximo 160 caracteres. El resumen que aparece en Google.'),

                            Forms\Components\TagsInput::make('seo_keywords')
                                ->label('Palabras Clave SEO')
                                ->nullable()
                                ->placeholder('Añadir y presionar Enter')
                                ->helperText('Términos de búsqueda relevantes para esta categoría.'),
                        ]),

                    Tabs\Tab::make('Archivos Multimedia')
                        ->icon('heroicon-o-photo')
                        ->schema([
                             FileUpload::make('image_path')
                                ->label('Imagen Principal')
                                ->directory('categories')
                                ->disk('public')
                                ->image()->imageEditor()
                                ->getUploadedFileNameForStorageUsing(self::getFileName('image')),

                            FileUpload::make('banner_path')
                                ->label('Banner de la Categoría')
                                ->directory('categories')
                                ->disk('public')
                                ->image()->imageEditor()
                                ->getUploadedFileNameForStorageUsing(self::getFileName('banner')),
                        ])->columns(2),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder-category.png')),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Category $record): string => $record->parent ? "Sub-categoría de: {$record->parent->name}" : 'Categoría Principal'),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->fontFamily('mono')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('products_count')->counts('products')
                    ->label('Productos')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Categoría Padre')
                    ->relationship('parent', 'name')
                    ->placeholder('Todas las categorías principales'),
            ])
            ->actions([
                Tables\Actions\Action::make('viewPublic')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Category $record): string => route('categories.show', ['category' => $record]))
                    ->openUrlInNewTab()
                    ->color('success')
                    ->tooltip('Ver categoría en la tienda')
                    ->iconButton(),
                Tables\Actions\ViewAction::make()->icon('heroicon-o-document-magnifying-glass')->color('gray')->tooltip('Ver detalles')->iconButton(),
                Tables\Actions\EditAction::make()->icon('heroicon-o-pencil-square')->color('warning')->tooltip('Editar')->iconButton(),
                Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash')->color('danger')->tooltip('Eliminar')->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Información de la Categoría')->schema([
                Infolists\Components\TextEntry::make('name')->label('Nombre')->weight('bold')->size('lg'),
                Infolists\Components\TextEntry::make('slug')->label('URL Slug')->icon('heroicon-o-link'),
                Infolists\Components\TextEntry::make('parent.name')->label('Categoría Padre')->badge(),
                Infolists\Components\TextEntry::make('description')->label('Descripción')->html()->columnSpanFull(),
            ])->columns(2),

            Infolists\Components\Section::make('Multimedia')->schema([
                Infolists\Components\ImageEntry::make('image_path')->label('Imagen Principal')->disk('public')->width('100%')->height('auto'),
                Infolists\Components\ImageEntry::make('banner_path')->label('Banner')->disk('public')->width('100%')->height('auto'),
            ])->columns(2),

            Infolists\Components\Section::make('SEO')->schema([
                Infolists\Components\TextEntry::make('seo_title')->label('Título SEO'),
                Infolists\Components\TextEntry::make('seo_description')->label('Descripción SEO'),
                Infolists\Components\TextEntry::make('seo_keywords')->label('Palabras Clave')->badge(),
            ])->columns(2)->collapsible(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }

    private static function getFileName(string $context): callable
    {
        return function (TemporaryUploadedFile $file, callable $get) use ($context): string {
            $name = $get('name');
            $slug = !empty($name) ? Str::slug($name) : pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $finalSlug = $context === 'banner' ? $slug . '-banner' : $slug;
            return (string) str($finalSlug)->append('-' . uniqid() . '.webp');
        };
    }
    
    public static function getModalWidth(): string
    {
        return '4xl';
    }
}
