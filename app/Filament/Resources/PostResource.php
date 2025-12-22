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
                                ->disabled(fn (string $operation): bool => $operation === 'edit')
                                ->helperText('URL amigable generada automáticamente a partir del título.'),
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
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->beforeLast('.')
                                        ->slug()
                                        ->append('-' . uniqid() . '.webp')
                                )->helperText('La imagen principal que se mostrará con el post.'),
                            Forms\Components\Select::make('user_id')
                                ->label('Autor')
                                ->relationship('user', 'name')
                                ->required()->searchable()->preload()->default(fn () => auth()->id()),
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
                ImageColumn::make('image_path')->label('Imagen')->disk('public')->circular()->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Autor')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('published_at')->label('Publicado')->boolean()->getStateUsing(fn (Post $record): bool => (bool) $record->published_at)->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->trueColor('success')->falseColor('danger'),
                Tables\Columns\TextColumn::make('published_at')->label('Fecha Publicación')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')->label('Autor')->relationship('user', 'name')->searchable()->preload(),
                Tables\Filters\TernaryFilter::make('published_at')->label('Estado de Publicación')->nullable()->trueLabel('Publicado')->falseLabel('Borrador'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_on_web')->icon('heroicon-o-arrow-top-right-on-square')->url(fn (Post $record): ?string => $record->slug && $record->published_at ? route('blog.show', $record->slug) : null)->openUrlInNewTab()->hidden(fn (Post $record): bool => empty($record->slug) || empty($record->published_at)),
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

    public static function getPages(): array
    {
        return [ 'index' => Pages\ManagePosts::route('/') ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([ SoftDeletingScope::class ]);
    }
}
