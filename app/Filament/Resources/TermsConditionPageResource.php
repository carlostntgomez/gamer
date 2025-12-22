<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermsConditionPageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;

class TermsConditionPageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $pageSlug = 'terms-condition';
    protected static ?string $navigationLabel = 'Página: Términos y Cond.';
    protected static ?string $modelLabel = 'Página: Términos y Condiciones';
    protected static ?string $pluralModelLabel = 'Página: Términos y Condiciones';
    protected static ?string $navigationGroup = 'Páginas Estáticas';

    public static function getRecordTitle(?\Illuminate\Database\Eloquent\Model $record): ?string
    {
        return $record->title;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('slug', static::$pageSlug);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información de la Página')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Título')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->disabled()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Publicado')
                                    ->default(false),
                                Forms\Components\TextInput::make('public_url')
                                    ->label('Enlace Público')
                                    ->formatStateUsing(fn (Page $record) => $record->slug ? route('page.show', $record->slug) : 'Página no disponible')
                                    ->disabled()
                                    ->visible(fn (Page $record) => $record->is_published && $record->slug),
                            ])->columns(2),

                        Forms\Components\Section::make('Contenido "Términos y Condiciones"')
                            ->description('Edita las secciones específicas de la página "Términos y Condiciones".')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('main_banner_image')
                                    ->label('Imagen del Banner')
                                    ->collection('main_banner_image')
                                    ->image()
                                    ->imageEditor(),

                                Forms\Components\TextInput::make('restriction_title')
                                    ->label('Título de Restricción')
                                    ->maxLength(255),
                                Forms\Components\Repeater::make('restriction_paragraphs')
                                    ->label('Párrafos de Restricción')
                                    ->schema([
                                        Forms\Components\RichEditor::make('paragraph_text')
                                            ->label('Texto del Párrafo')
                                            ->required()
                                            ->maxLength(65535),
                                    ])
                                    ->minItems(0)
                                    ->collapsible()
                                    ->columnSpanFull(),
                                
                                Forms\Components\Repeater::make('condition_items')
                                    ->label('Items de Términos y Condiciones')
                                    ->schema([
                                        Forms\Components\TextInput::make('condition_title')
                                            ->label('Título del Item')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\RichEditor::make('condition_paragraph')
                                            ->label('Párrafo del Item')
                                            ->required()
                                            ->maxLength(65535),
                                    ])
                                    ->minItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['condition_title'] ?? null)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('need_help_title')
                                    ->label('Título de Sección "Necesitas Ayuda"')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Repeater::make('help_items')
                                    ->label('Items de Ayuda')
                                    ->schema([
                                        Forms\Components\FileUpload::make('item_image')
                                            ->label('Imagen del Item')
                                            ->directory('page-help-items')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->maxFiles(1)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('item_icon')
                                            ->label('Ícono (Clase CSS)')
                                            ->nullable(),
                                        Forms\Components\TextInput::make('item_title')
                                            ->label('Título')
                                            ->required(),
                                        Forms\Components\Textarea::make('item_description')
                                            ->label('Descripción')
                                            ->required()
                                            ->rows(3)
                                            ->maxLength(65535),
                                    ])
                                    ->minItems(0)
                                    ->defaultItems(3)
                                    ->grid(2)
                                    ->collapsible()
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
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['content']) && is_array($data['content'])) {
            $contentData = $data['content'];
            $data['restriction_title'] = $contentData['restriction_title'] ?? null;
            $data['restriction_paragraphs'] = $contentData['restriction_paragraphs'] ?? [];
            $data['condition_items'] = $contentData['condition_items'] ?? [];
            $data['need_help_title'] = $contentData['need_help_title'] ?? null;
            $data['help_items'] = $contentData['help_items'] ?? [];
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $contentData = [
            'restriction_title' => $data['restriction_title'] ?? null,
            'restriction_paragraphs' => $data['restriction_paragraphs'] ?? [],
            'condition_items' => $data['condition_items'] ?? [],
            'need_help_title' => $data['need_help_title'] ?? null,
            'help_items' => $data['help_items'] ?? [],
        ];
        $data['content'] = $contentData;

        unset(
            $data['restriction_title'],
            $data['restriction_paragraphs'],
            $data['condition_items'],
            $data['need_help_title'],
            $data['help_items']
        );

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
                Tables\Actions\EditAction::make()->iconButton()->color('primary')->modal(),
                Tables\Actions\Action::make('view_on_web')
                    ->iconButton()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Page $record): ?string => $record->slug ? route('page.show', $record->slug) : null)
                    ->openUrlInNewTab()
                    ->hidden(fn (Page $record): bool => empty($record->slug) || !$record->is_published),
            ])
            ->bulkActions([
                // No bulk actions for a single page
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->modal(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTermsConditionPages::route('/'),
        ];
    }
}
