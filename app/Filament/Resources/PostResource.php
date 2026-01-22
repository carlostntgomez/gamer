<?php

namespace App\Filament\Resources;

use App\Filament\Actions\GeneratePostContentAction;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;

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
        return $form->schema(self::getFormSchema());
    }

    public static function getFormSchema(): array
    {
        return [
            Actions::make([
                GeneratePostContentAction::make(),
            ])->columnSpanFull(),

            Section::make('Imagen Destacada')
                ->collapsible()
                ->schema([
                    FileUpload::make('main_image_path')
                        ->label('Imagen Destacada')
                        ->directory('temp-uploads')
                        ->disk('public')
                        ->image()
                        ->imageEditor()
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('675')
                        ->helperText('La imagen se procesará a 1200x675px (16:9) y se convertirá a WebP.'),
                ]),

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
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                    $set('seo_title', $state);
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(Post::class, 'slug', ignoreRecord: true)
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

                Tabs\Tab::make('Metadatos')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Forms\Components\Select::make('author_id')
                            ->label('Autor')
                            ->relationship('author', 'name')
                            ->required()->searchable()->preload(),
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
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image_path')->label('Imagen')->disk('public')->square()->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable()->weight('bold')->description(fn (Post $record): string => Str::limit($record->excerpt, 40)),
                Tables\Columns\TextColumn::make('author.name')->label('Autor')->searchable()->sortable()->badge(),
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
                Tables\Columns\TextColumn::make('updated_at')->label('Última actualización')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author_id')->label('Autor')->relationship('author', 'name')->searchable()->preload(),
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
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make()->schema([
                Infolists\Components\Group::make([
                    Infolists\Components\TextEntry::make('title')->label('Título')->weight('bold')->size('lg'),
                    Infolists\Components\TextEntry::make('slug')->label('URL Slug')->icon('heroicon-o-link'),
                    Infolists\Components\TextEntry::make('author.name')->label('Autor')->badge(),
                    Infolists\Components\TextEntry::make('tags.name')->label('Etiquetas')->badge(),
                    Infolists\Components\TextEntry::make('published_at')->label('Fecha de Publicación')->dateTime('d/m/Y H:i'),
                ])->columns(2),
                Infolists\Components\ImageEntry::make('main_image_path')->label('Imagen Principal')->disk('public')->width('100%')->height('auto'),
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

    public static function getModalWidth(): string
    {
        return '5xl';
    }
}
