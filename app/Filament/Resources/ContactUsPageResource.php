<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactUsPageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactUsPageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $pageSlug = 'contact-us';
    protected static ?string $navigationLabel = 'Página: Contáctanos';
    protected static ?string $modelLabel = 'Página: Contáctanos';
    protected static ?string $pluralModelLabel = 'Página: Contáctanos';
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

                        Forms\Components\Section::make('Contenido "Contáctanos"')
                            ->description('Edita las secciones específicas de la página "Contáctanos".')
                            ->schema([
                                Forms\Components\RichEditor::make('main_content')
                                    ->label('Contenido Principal')
                                    ->maxLength(65535)
                                    ->fileAttachmentsDirectory('page-attachments/contact-us')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('map_embed_url')
                                    ->label('URL de Mapa (Embed)')
                                    ->url()
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('address_line_1')
                                            ->label('Dirección Línea 1')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address_line_2')
                                            ->label('Dirección Línea 2')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('phone_number_1')
                                            ->label('Teléfono 1')
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone_number_2')
                                            ->label('Teléfono 2 (opcional)')
                                            ->tel()
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('email_address_1')
                                            ->label('Email 1')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email_address_2')
                                            ->label('Email 2 (opcional)')
                                            ->email()
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                            ])->columns(1),
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
            $data['main_content'] = $contentData['main_content'] ?? null;
            $data['map_embed_url'] = $contentData['map_embed_url'] ?? null;
            $data['address_line_1'] = $contentData['address_line_1'] ?? null;
            $data['address_line_2'] = $contentData['address_line_2'] ?? null;
            $data['phone_number_1'] = $contentData['phone_number_1'] ?? null;
            $data['phone_number_2'] = $contentData['phone_number_2'] ?? null;
            $data['email_address_1'] = $contentData['email_address_1'] ?? null;
            $data['email_address_2'] = $contentData['email_address_2'] ?? null;
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $contentData = [
            'main_content' => $data['main_content'] ?? null,
            'map_embed_url' => $data['map_embed_url'] ?? null,
            'address_line_1' => $data['address_line_1'] ?? null,
            'address_line_2' => $data['address_line_2'] ?? null,
            'phone_number_1' => $data['phone_number_1'] ?? null,
            'phone_number_2' => $data['phone_number_2'] ?? null,
            'email_address_1' => $data['email_address_1'] ?? null,
            'email_address_2' => $data['email_address_2'] ?? null,
        ];
        $data['content'] = $contentData;

        // Unset the temporary flat fields from the data array
        unset(
            $data['main_content'],
            $data['map_embed_url'],
            $data['address_line_1'],
            $data['address_line_2'],
            $data['phone_number_1'],
            $data['phone_number_2'],
            $data['email_address_1'],
            $data['email_address_2']
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
            'index' => Pages\ListContactUsPages::route('/'),
            'create' => Pages\CreateContactUsPage::route('/create'),
            'view' => Pages\ViewContactUsPage::route('/{record}'),
            'edit' => Pages\EditContactUsPage::route('/{record}/edit'),
        ];
    }
}
