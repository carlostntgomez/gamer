<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrivacyPolicyPageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;

class PrivacyPolicyPageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $pageSlug = 'privacy-policy';
    protected static ?string $navigationLabel = 'Página: Política de Privacidad';
    protected static ?string $modelLabel = 'Página: Política de Privacidad';
    protected static ?string $pluralModelLabel = 'Página: Política de Privacidad';
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

                        Forms\Components\Section::make('Contenido "Política de Privacidad"')
                            ->description('Edita las secciones específicas de la página "Política de Privacidad".')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('main_banner_image')
                                    ->label('Imagen del Banner')
                                    ->collection('main_banner_image')
                                    ->image()
                                    ->imageEditor(),

                                Forms\Components\Repeater::make('policy_points')
                                    ->label('Puntos de la Política')
                                    ->schema([
                                        Forms\Components\RichEditor::make('point_text')
                                            ->label('Texto del Punto')
                                            ->required()
                                            ->maxLength(65535),
                                    ])
                                    ->minItems(1)
                                    ->collapsible()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('pay_policy_liability_title')
                                    ->label('Título de Responsabilidad (Política de Pago)')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\RichEditor::make('pay_policy_liability_text')
                                    ->label('Texto de Responsabilidad (Política de Pago)')
                                    ->maxLength(65535)
                                    ->fileAttachmentsDirectory('page-attachments/privacy-policy-liability')
                                    ->nullable()
                                    ->columnSpanFull(),
                                
                                Forms\Components\Repeater::make('pay_policy_features')
                                    ->label('Características de la Política de Pago')
                                    ->schema([
                                        Forms\Components\TextInput::make('icon')
                                            ->label('Ícono (Clase CSS)')
                                            ->nullable(),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Título')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Descripción')
                                            ->required()
                                            ->rows(3)
                                            ->maxLength(65535),
                                    ])
                                    ->minItems(0)
                                    ->defaultItems(5)
                                    ->grid(2)
                                    ->collapsible()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('popular_methods_title')
                                    ->label('Título de Métodos Populares')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Repeater::make('payment_methods')
                                    ->label('Métodos de Pago')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('method_image')
                                            ->label('Imagen del Método')
                                            ->collection('payment_methods')
                                            ->image()
                                            ->disk('public')
                                            ->directory('payment-methods')
                                            ->visibility('public')
                                            ->maxFiles(1),
                                        Forms\Components\TextInput::make('method_title')
                                            ->label('Título del Método')
                                            ->required(),
                                        Forms\Components\Textarea::make('method_description')
                                            ->label('Descripción')
                                            ->required()
                                            ->rows(2)
                                            ->maxLength(65535),
                                    ])
                                    ->minItems(0)
                                    ->defaultItems(8)
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
            $data['policy_points'] = $contentData['policy_points'] ?? [];
            $data['pay_policy_liability_title'] = $contentData['pay_policy_liability_title'] ?? null;
            $data['pay_policy_liability_text'] = $contentData['pay_policy_liability_text'] ?? null;
            $data['pay_policy_features'] = $contentData['pay_policy_features'] ?? [];
            $data['popular_methods_title'] = $contentData['popular_methods_title'] ?? null;
            $data['payment_methods'] = $contentData['payment_methods'] ?? [];
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $contentData = [
            'policy_points' => $data['policy_points'] ?? [],
            'pay_policy_liability_title' => $data['pay_policy_liability_title'] ?? null,
            'pay_policy_liability_text' => $data['pay_policy_liability_text'] ?? null,
            'pay_policy_features' => $data['pay_policy_features'] ?? [],
            'popular_methods_title' => $data['popular_methods_title'] ?? null,
            'payment_methods' => $data['payment_methods'] ?? [],
        ];
        $data['content'] = $contentData;

        unset(
            $data['policy_points'],
            $data['pay_policy_liability_title'],
            $data['pay_policy_liability_text'],
            $data['pay_policy_features'],
            $data['popular_methods_title'],
            $data['payment_methods']
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
            'index' => Pages\ListPrivacyPolicyPages::route('/'),
            'create' => Pages\CreatePrivacyPolicyPage::route('/create'),
            'view' => Pages\ViewPrivacyPolicyPage::route('/{record}'),
            'edit' => Pages\EditPrivacyPolicyPage::route('/{record}/edit'),
        ];
    }
}
