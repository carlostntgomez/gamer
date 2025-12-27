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
use Filament\Forms\Components\Section;
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
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre de la Marca')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                        $set('slug', Str::slug($state));
                        $set('seo_title', $state);
                    })
                    ->columnSpan(1),

                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->directory('brands')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->imagePreviewHeight('150')
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file, callable $get): string => Str::slug($get('name')) . '-' . uniqid() . '.' . $file->guessExtension()
                    )
                    ->helperText('Sube el logo de la marca.')
                    ->columnSpan(1),

                Forms\Components\RichEditor::make('description')
                    ->label('Descripción')
                    ->columnSpanFull()
                    ->nullable(),
            ]),

            Section::make('Contenido SEO')
                ->icon('heroicon-o-magnifying-glass')
                ->collapsible()
                ->collapsed()
                ->description('Optimiza esta marca para los motores de búsqueda.')
                ->schema([
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug (URL Amigable)')
                        ->required()
                        ->unique(Brand::class, 'slug', ignoreRecord: true)
                        ->helperText('Generado automáticamente, pero puedes ajustarlo.'),

                    Forms\Components\TextInput::make('seo_title')
                        ->label('Título SEO')
                        ->maxLength(60)
                        ->helperText('Máximo 60 caracteres. Ideal para Google.'),

                    Forms\Components\Textarea::make('seo_description')
                        ->label('Descripción SEO')
                        ->maxLength(160)
                        ->rows(3)
                        ->helperText('Máximo 160 caracteres. El resumen para Google.'),

                    Forms\Components\TagsInput::make('seo_keywords')
                        ->label('Palabras Clave SEO'),
                ]),
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
                TextColumn::make('products_count')->counts('products')
                    ->label('Productos')
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d/m/Y H:i')
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
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
        ];
    }
}
