<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqPageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;

class FaqPageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $pageSlug = 'faq';
    protected static ?string $navigationLabel = 'Página: FAQ';
    protected static ?string $modelLabel = 'Página: Preguntas Frecuentes';
    protected static ?string $pluralModelLabel = 'Página: Preguntas Frecuentes';
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

                        Forms\Components\Section::make('Contenido "Preguntas Frecuentes"')
                            ->description('Edita las secciones específicas de la página "Preguntas Frecuentes".')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('main_banner_image')
                                    ->label('Imagen del Banner')
                                    ->collection('main_banner_image')
                                    ->image()
                                    ->imageEditor(),

                                Forms\Components\Repeater::make('faq_items')
                                    ->label('Preguntas y Respuestas')
                                    ->schema([
                                        Forms\Components\TextInput::make('question')
                                            ->label('Pregunta')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\RichEditor::make('answer')
                                            ->label('Respuesta')
                                            ->required()
                                            ->maxLength(65535)
                                            ->fileAttachmentsDirectory('page-attachments/faq'),
                                    ])
                                    ->minItems(1)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('help_desk_items')
                                    ->label('Soporte de Help Desk')
                                    ->schema([
                                        Forms\Components\TextInput::make('icon')
                                            ->label('Ícono (Clase CSS o URL)')
                                            ->nullable(),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Título')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\RichEditor::make('description')
                                            ->label('Descripción')
                                            ->required()
                                            ->maxLength(65535)
                                            ->fileAttachmentsDirectory('page-attachments/help-desk'),
                                    ])
                                    ->minItems(0)
                                    ->defaultItems(2)
                                    ->grid(2)
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
            $data['faq_items'] = $contentData['faq_items'] ?? [];
            $data['help_desk_items'] = $contentData['help_desk_items'] ?? [];
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $contentData = [
            'faq_items' => $data['faq_items'] ?? [],
            'help_desk_items' => $data['help_desk_items'] ?? [],
        ];
        $data['content'] = $contentData;

        unset($data['faq_items'], $data['help_desk_items']);
        
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
            'index' => Pages\ListFaqPages::route('/'),
            'create' => Pages\CreateFaqPage::route('/create'),
            'view' => Pages\ViewFaqPage::route('/{record}'),
            'edit' => Pages\EditFaqPage::route('/{record}/edit'),
        ];
    }
}
