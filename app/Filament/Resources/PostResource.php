<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

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
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información del Post')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Título')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\Select::make('user_id')
                                    ->label('Autor')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->default(fn () => auth()->id()),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Fecha de Publicación')
                                    ->nullable()
                                    ->native(false),
                            ])->columns(2),

                        Forms\Components\Section::make('Contenido')
                            ->schema([
                                Forms\Components\RichEditor::make('content')
                                    ->label('Contenido del Post')
                                    ->required()
                                    ->maxLength(65535)
                                    ->fileAttachmentsDirectory('post-attachments')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Extracto')
                                    ->maxLength(65535)
                                    ->rows(5)
                                    ->nullable()
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Imagen Destacada')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('featured_image')
                                    ->collection('featured_image')
                                    ->label('Imagen Destacada')
                                    ->image()
                                    ->maxFiles(1)
                                    ->imageEditor()
                                    ->getUploadedFileNameForStorageUsing(function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, ?Model $record): string {
                                        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                        $recordName = $record?->title ?? $fileName;
                                        return (string) str('post-' . str_replace('-', '', Str::slug($recordName)))->slug() . '.' . $file->getClientOriginalExtension();
                                    })
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('Título SEO')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Textarea::make('seo_description')
                                    ->label('Descripción SEO')
                                    ->maxLength(65535)
                                    ->rows(3)
                                    ->nullable(),
                                Forms\Components\TagsInput::make('seo_keywords')
                                    ->label('Palabras Clave SEO')
                                    ->placeholder('Añadir palabra clave')
                                    ->nullable(),
                            ]),
                        Forms\Components\Section::make('Etiquetas')
                            ->schema([
                                Forms\Components\Select::make('tags')
                                    ->label('Etiquetas')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable(),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->label('Imagen Destacada')
                    ->collection('featured_image')
                    ->conversion('thumb')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('published_at')
                    ->label('Publicado')
                    ->boolean()
                    ->getStateUsing(fn (Post $record): bool => (bool) $record->published_at)
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Fecha Publicación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Autor')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('published_at')
                    ->label('Estado de Publicación')
                    ->nullable()
                    ->trueLabel('Publicado')
                    ->falseLabel('Borrador')
                    ->placeholder('Todos'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
                Tables\Actions\EditAction::make()->iconButton()->color('primary'),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
                Tables\Actions\ForceDeleteAction::make()->iconButton()->color('danger'),
                Tables\Actions\RestoreAction::make()->iconButton()->color('success'),
                Tables\Actions\Action::make('view_on_web')
                    ->iconButton()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Post $record): ?string => $record->slug && $record->published_at ? route('blog.show', $record->slug) : null)
                    ->openUrlInNewTab()
                    ->hidden(fn (Post $record): bool => empty($record->slug) || empty($record->published_at)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
