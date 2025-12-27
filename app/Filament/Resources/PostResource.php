<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $modelLabel = 'Publicación';
    protected static ?string $pluralModelLabel = 'Publicaciones';
    protected static ?string $navigationLabel = 'Blog';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Actions::make([
                    Action::make('generateContent')
                        ->label('Generar Contenido con IA')
                        ->icon('heroicon-o-sparkles')
                        ->color('primary')
                        ->action(function (Forms\Set $set, Forms\Get $get) {
                            $apiKey = config('gemini.api_key');
                            $postTitle = $get('title');

                            if (empty($apiKey)) {
                                Notification::make()->title('Error')->body('La clave API de Gemini no está configurada.')->danger()->send();
                                return;
                            }

                            if (empty($postTitle)) {
                                Notification::make()->title('Error')->body('Por favor, introduce el título del post.')->danger()->send();
                                return;
                            }

                            $prompt = <<<PROMPT
Actúa como un Blogger experto y Estratega SEO para TecnnyGames, una tienda online líder en el sector gaming. Eres conocido por escribir artículos que son a la vez informativos, entretenidos y que posicionan muy bien en Google.

**REGLAS CRÍTICAS e INQUEBRANTABLES:**
- Los límites de caracteres son ESTRICTOS. NUNCA, bajo ninguna circunstancia, debes excederlos.
- `seo_title`: MÁXIMO 60 caracteres.
- `seo_description`: MÁXIMO 160 caracteres.
- `excerpt`: MÁXIMO 255 caracteres.

Tu objetivo es crear un post de blog completo, persuasivo y optimizado para SEO, dirigido a nuestra audiencia de gamers, entusiastas de la tecnología y cultura pop.

Basándote EXCLUSIVAMENTE en el título proporcionado, genera el siguiente contenido:
Título del Post: {$postTitle}
PROMPT;

                            $schema = [
                                'type' => 'OBJECT',
                                'properties' => [
                                    'content' => ['type' => 'STRING', 'description' => 'El contenido completo del artículo en formato HTML. Debe estar bien estructurado con encabezados (<h3>, <h4>), listas (<ul><li>), negritas (<strong>) y párrafos (<p>). Debe ser informativo, atractivo y relevante para el título. El tono debe ser entusiasta y conocedor del mundo gaming.'],
                                    'excerpt' => ['type' => 'STRING', 'description' => 'Un extracto o resumen conciso y atractivo del post (máx 255 chars). Ideal para mostrar en listados de blog y redes sociales.'],
                                    'seo_title' => ['type' => 'STRING', 'description' => 'Título SEO optimizado. REGLA ESTRICTA: NO DEBE SUPERAR los 60 caracteres. Debe ser idéntico o una ligera variación atractiva del título principal.'],
                                    'seo_description' => ['type' => 'STRING', 'description' => 'Meta descripción SEO persuasiva. REGLA ESTRICTA: NO DEBE SUPERAR los 160 caracteres. Debe resumir el contenido e incitar al clic.'],
                                    'seo_keywords' => ['type' => 'STRING', 'description' => 'Una lista de 5 a 7 palabras clave y términos de búsqueda relevantes para el post, separadas por comas.'],
                                ],
                                'required' => ['content', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords']
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
                                        $set('content', $contentJson['content'] ?? null);

                                        $excerpt = $contentJson['excerpt'] ?? '';
                                        if (mb_strlen($excerpt) > 255) {
                                            $truncated = mb_substr($excerpt, 0, 252);
                                            $lastSpace = mb_strrpos($truncated, ' ');
                                            $excerpt = ($lastSpace !== false) ? mb_substr($truncated, 0, $lastSpace) . '...' : $truncated . '...';
                                        }
                                        $set('excerpt', $excerpt);

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

                                        Notification::make()->title('¡Éxito!')->body('El contenido del post ha sido generado.')->success()->send();
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
                Tabs::make('PostTabs')->tabs([
                    Tabs\Tab::make('Contenido Principal')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Título del Post')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                    $set('slug', Str::slug($state));
                                    $set('seo_title', $state);
                                }),
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->live()
                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                                ->helperText('URL amigable generada automáticamente.'),
                            Forms\Components\RichEditor::make('content')
                                ->label('Contenido del Post')
                                ->required()
                                ->maxLength(65535)
                                ->fileAttachmentsDirectory('post-attachments')
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('excerpt')
                                ->label('Extracto')
                                ->maxLength(255)
                                ->rows(3)
                                ->helperText('Un resumen corto que se mostrará en las listas de posts.')
                                ->columnSpanFull(),
                        ])->columns(2),

                    Tabs\Tab::make('Metadatos y Multimedia')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Forms\Components\FileUpload::make('image_path')
                                ->label('Imagen Destacada')
                                ->directory('posts')->disk('public')->image()->imageEditor()
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file, callable $get): string => (string) str(Str::slug($get('title')))
                                        ->append('-' . uniqid() . '.webp')
                                )->helperText('La imagen principal que se mostrará con el post.'),
                            Forms\Components\Select::make('user_id')
                                ->label('Autor')
                                ->relationship('user', 'name')
                                ->required()->searchable()->preload()->default(fn () => Auth::id()),
                            Forms\Components\Select::make('tags')
                                ->label('Etiquetas')
                                ->relationship('tags', 'name')
                                ->multiple()->preload()->searchable(),
                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Fecha de Publicación')
                                ->native(false)
                                ->helperText('Si se establece una fecha futura, el post se publicará automáticamente en ese momento.'),
                        ])->columns(2),

                    Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('seo_title')
                                ->label('Título SEO')
                                ->maxLength(60)
                                ->helperText('Recomendado: Máximo 60 caracteres. Se autocompleta con el título del post.'),
                            Forms\Components\Textarea::make('seo_description')
                                ->label('Descripción SEO')
                                ->maxLength(160)
                                ->rows(3)
                                ->helperText('Recomendado: Máximo 160 caracteres. Un resumen para Google.'),
                            Forms\Components\TagsInput::make('seo_keywords')
                                ->label('Palabras Clave SEO')
                                ->placeholder('Añadir palabra clave'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('Imagen')->disk('public')->square()->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable()->weight('bold')->description(fn (Post $record): string => Str::limit($record->excerpt, 40)),
                Tables\Columns\TextColumn::make('user.name')->label('Autor')->searchable()->sortable()->badge(),
                Tables\Columns\IconColumn::make('published_at')->label('Estado')
                    ->icon(fn (Post $record): string => 
                        !$record->published_at ? 'heroicon-o-clock' : 
                        ($record->published_at > now() ? 'heroicon-o-arrow-up-on-square' : 'heroicon-o-check-circle'))
                    ->color(fn (Post $record): string => 
                        !$record->published_at ? 'gray' : 
                        ($record->published_at > now() ? 'warning' : 'success'))
                    ->tooltip(fn (Post $record): string => 
                        !$record->published_at ? 'Borrador' : 
                        ($record->published_at > now() ? 'Programado para ' . $record->published_at->format('d/m/Y H:i') : 'Publicado el ' . $record->published_at->format('d/m/Y H:i'))),
                Tables\Columns\TextColumn::make('updated_at')->label('Última actualización')->dateTime('d/m/Y')->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')->label('Autor')->relationship('user', 'name')->searchable()->preload(),
                Tables\Filters\TernaryFilter::make('published_at')->label('Estado')->nullable()->trueLabel('Publicado')->falseLabel('Borrador')->queries(
                    true: fn (Builder $query) => $query->whereNotNull('published_at')->where('published_at', '<', now()),
                    false: fn (Builder $query) => $query->whereNull('published_at')->orWhere('published_at', '>', now()),
                ),
            ])
            ->actions([
                Tables\Actions\Action::make('view_live')
                    ->label('Ver en web')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('info')
                    ->url(fn (Post $record): string => route('posts.show', $record))
                    ->openUrlInNewTab()
                    ->iconButton()
                    ->tooltip('Ver el post en el sitio web')
                    ->visible(fn (Post $record): bool => $record->published_at && $record->published_at <= now()),
                Tables\Actions\ViewAction::make()->icon('heroicon-o-document-magnifying-glass')->color('gray')->tooltip('Ver detalles')->iconButton(),
                Tables\Actions\EditAction::make()->icon('heroicon-o-pencil-square')->color('warning')->tooltip('Editar')->iconButton(),
                Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash')->color('danger')->tooltip('Eliminar')->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([ SoftDeletingScope::class ]));
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make()->schema([
                Infolists\Components\Group::make([
                    Infolists\Components\TextEntry::make('title')->label('Título')->weight('bold')->size('lg'),
                    Infolists\Components\TextEntry::make('slug')->label('URL Slug')->icon('heroicon-o-link'),
                    Infolists\Components\TextEntry::make('user.name')->label('Autor')->badge(),
                    Infolists\Components\TextEntry::make('tags.name')->label('Etiquetas')->badge(),
                    Infolists\Components\TextEntry::make('published_at')->label('Fecha de Publicación')->dateTime('d/m/Y H:i'),
                ])->columns(2),
                Infolists\Components\ImageEntry::make('image_path')->label('Imagen Principal')->disk('public')->width('100%')->height('auto'),
            ])->columns(2),
            Infolists\Components\Section::make('Contenido')->schema([
                Infolists\Components\TextEntry::make('excerpt')->label('Extracto'),
                Infolists\Components\TextEntry::make('content')->label('Contenido Completo')->html(),
            ])->collapsible(),
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
            'index' => Pages\ListPosts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([ SoftDeletingScope::class ]);
    }

    public static function getModalWidth(): string
    {
        return '5xl';
    }
}
