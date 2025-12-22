<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentPolicyPageResource\Pages;
use App\Models\PaymentPolicyPage as PaymentPolicyPageModel; // Usar el nuevo modelo
use App\Models\Page; // Se mantiene para referencias
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;

class PaymentPolicyPageResource extends Resource
{
    protected static ?string $model = PaymentPolicyPageModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Página: Política de Pago';
    protected static ?string $modelLabel = 'Página: Política de Pago';
    protected static ?string $pluralModelLabel = 'Página: Política de Pago';
    protected static ?string $navigationGroup = 'Páginas Estáticas';

    // Los métodos getEloquentQuery y getRecordTitle ya no son necesarios.

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

                        Forms\Components\Section::make('Contenido "Política de Pago"')
                            ->description('Edita las secciones específicas de la página "Política de Pago".')
                            ->schema([
                                Forms\Components\RichEditor::make('main_content')
                                    ->label('Contenido Principal')
                                    ->maxLength(65535)
                                    ->fileAttachmentsDirectory('page-attachments/payment-policy')
                                    ->columnSpanFull(),
                                Repeater::make('policy_items')
                                    ->label('Preguntas y Respuestas de la Política')
                                    ->schema([
                                        Forms\Components\TextInput::make('question')
                                            ->label('Pregunta')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\RichEditor::make('answer')
                                            ->label('Respuesta')
                                            ->required()
                                            ->maxLength(65535)
                                            ->fileAttachmentsDirectory('page-attachments/payment-policy-qa'),
                                    ])
                                    ->minItems(1)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
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

    // Los métodos `mutateFormDataBeforeFill` y `mutateFormDataBeforeSave` han sido eliminados.

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
            'index' => Pages\ListPaymentPolicyPages::route('/'),
        ];
    }
}
