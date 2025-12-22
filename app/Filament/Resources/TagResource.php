<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $modelLabel = 'Etiqueta';
    protected static ?string $pluralModelLabel = 'Etiquetas';
    protected static ?string $navigationLabel = 'Etiquetas';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('TagTabs')->tabs([
                    Tabs\Tab::make('Detalles de la Etiqueta')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre de la Etiqueta')
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
                                ->helperText('URL amigable generada automáticamente a partir del nombre.'),
                        ]),
                    Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('seo_title')
                                ->label('Título SEO')
                                ->maxLength(60)
                                ->helperText('Recomendado: Máximo 60 caracteres. Se autocompleta con el nombre de la etiqueta.'),
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
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('posts_count')->label('Nº Posts')->counts('posts')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]),
            ])
            ->defaultSort('name', 'asc')
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([ SoftDeletingScope::class ]));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTags::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([ SoftDeletingScope::class ]);
    }
}
