<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsPageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class AboutUsPageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $pageSlug = 'about-us';
    protected static ?string $navigationLabel = 'Página: Acerca de';
    protected static ?string $modelLabel = 'Página: Acerca de Nosotros';
    protected static ?string $pluralModelLabel = 'Página: Acerca de Nosotros';
    protected static ?string $navigationGroup = 'Páginas Estáticas';

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

                        Forms\Components\Section::make('Contenido "Acerca de Nosotros"')
                            ->description('Edita las secciones específicas de la página "Acerca de Nosotros".')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('main_banner_image')
                                    ->label('Imagen del Banner')
                                    ->collection('main_banner_image')
                                    ->image()
                                    ->imageEditor(),
                                
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('mission_title')
                                            ->label('Título de la Misión')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('vision_title')
                                            ->label('Título de la Visión')
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\RichEditor::make('mission_paragraph')
                                            ->label('Párrafo de la Misión')
                                            ->maxLength(65535)
                                            ->fileAttachmentsDirectory('page-attachments/mission'),
                                        Forms\Components\RichEditor::make('vision_paragraph')
                                            ->label('Párrafo de la Visión')
                                            ->maxLength(65535)
                                            ->fileAttachmentsDirectory('page-attachments/vision'),
                                    ]),

                                Forms\Components\Repeater::make('project_counts')
                                    ->label('Contadores de Proyecto')
                                    ->schema([
                                        Forms\Components\TextInput::make('count_number')
                                            ->label('Número')
                                            ->numeric()
                                            ->required(),
                                        Forms\Components\TextInput::make('count_label')
                                            ->label('Etiqueta')
                                            ->required(),
                                        Forms\Components\TextInput::make('count_image')
                                            ->label('URL de Icono')
                                            ->url()
                                            ->nullable(),
                                    ])
                                    ->defaultItems(4)
                                    ->minItems(0)
                                    ->maxItems(4)
                                    ->grid(4)
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('team_members')
                                    ->label('Miembros del Equipo')
                                    ->schema([
                                        Forms\Components\TextInput::make('member_name')
                                            ->label('Nombre')
                                            ->required(),
                                        Forms\Components\TextInput::make('member_designation')
                                            ->label('Cargo')
                                            ->required(),
                                        Forms\Components\Textarea::make('member_description')
                                            ->label('Descripción')
                                            ->rows(3)
                                            ->maxLength(65535)
                                            ->nullable(),
                                        Forms\Components\FileUpload::make('member_image')
                                            ->label('Imagen del Miembro')
                                            ->directory('page-team-members')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->maxFiles(1)
                                            ->nullable(),
                                    ])
                                    ->defaultItems(4)
                                    ->minItems(0)
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
            $data['mission_title'] = $contentData['mission_title'] ?? null;
            $data['mission_paragraph'] = $contentData['mission_paragraph'] ?? null;
            $data['vision_title'] = $contentData['vision_title'] ?? null;
            $data['vision_paragraph'] = $contentData['vision_paragraph'] ?? null;
            $data['project_counts'] = $contentData['project_counts'] ?? [];
            $data['team_members'] = $contentData['team_members'] ?? [];
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $contentData = [
            'mission_title' => $data['mission_title'] ?? null,
            'mission_paragraph' => $data['mission_paragraph'] ?? null,
            'vision_title' => $data['vision_title'] ?? null,
            'vision_paragraph' => $data['vision_paragraph'] ?? null,
            'project_counts' => $data['project_counts'] ?? [],
            'team_members' => $data['team_members'] ?? [],
        ];
        $data['content'] = $contentData;

        // Unset the temporary flat fields from the data array
        unset(
            $data['mission_title'],
            $data['mission_paragraph'],
            $data['vision_title'],
            $data['vision_paragraph'],
            $data['project_counts'],
            $data['team_members']
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
            'index' => Pages\ListAboutUsPages::route('/'),
            'create' => Pages\CreateAboutUsPage::route('/create'),
            'view' => Pages\ViewAboutUsPage::route('/{record}'),
            'edit' => Pages\EditAboutUsPage::route('/{record}/edit'),
        ];
    }
}
