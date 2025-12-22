<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Marca';
    protected static ?string $pluralModelLabel = 'Marcas';
    protected static ?string $navigationLabel = 'Marcas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('BrandTabs')->tabs([
                Tabs\Tab::make('Información Principal')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre de la Marca')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                $set('slug', Str::slug($state));
                                $set('seo_title', $state);
                            }),

                        Forms\Components\RichEditor::make('description')
                            ->label('Descripción de la Marca')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Tabs\Tab::make('Logo de la Marca')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Logo')
                            ->directory('brands')
                            ->disk('public')
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('200')
                            ->getUploadedFileNameForStorageUsing(
                                fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->beforeLast('.')
                                    ->slug()
                                    ->append('-' . uniqid() . '.webp')
                            )
                            ->helperText('Sube el logo representativo de la marca (preferiblemente cuadrado).'),
                    ]),

                Tabs\Tab::make('Contenido SEO')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(Brand::class, 'slug', ignoreRecord: true)
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->helperText('URL amigable (no cambiar una vez creada).'),

                        Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(60)
                            ->helperText('Recomendado: Máximo 60 caracteres. Se autocompleta con el nombre de la marca.'),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('Descripción SEO')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Recomendado: Máximo 160 caracteres. Un resumen para Google.'),

                        Forms\Components\TagsInput::make('seo_keywords')
                            ->label('Palabras Clave SEO')
                            ->placeholder('Añadir etiqueta'),
                    ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder-brand.png')),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
                Tables\Actions\EditAction::make()->iconButton()->color('primary'),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
        ];
    }
}
