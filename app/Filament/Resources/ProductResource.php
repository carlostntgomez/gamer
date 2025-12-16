<?php

namespace App\Filament\Resources;

use App\Enums\ProductCondition;
use App\Enums\ProductType;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationLabel = 'Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Group::make()->schema([
                        Section::make('Información del Producto')->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')
                                ->required()
                                ->unique(Product::class, 'slug', ignoreRecord: true),
                            MarkdownEditor::make('description')
                                ->label('Descripción')
                                ->columnSpanFull(),
                        ]),
                        Section::make('Imágenes')->schema([
                            SpatieMediaLibraryFileUpload::make('media_main')
                                ->collection('main_image')
                                ->label('Imagen Principal')
                                ->image()
                                ->nullable()
                                ->getUploadedFileNameForStorageUsing(function (?TemporaryUploadedFile $file, ?Model $record): string {
                                    if (!$file) {
                                        return '';
                                    }
                                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                    $recordName = $record?->name ?? $fileName;
                                    return (string) str('product-' . str_replace('-', '', Str::slug($recordName)))->slug() . '.' . $file->getClientOriginalExtension();
                                }),
                            SpatieMediaLibraryFileUpload::make('media_gallery')
                                ->collection('gallery_images')
                                ->label('Galería de Imágenes')
                                ->multiple()
                                ->maxFiles(5)
                                ->image()
                                ->nullable()
                                ->reorderable()
                                ->getUploadedFileNameForStorageUsing(function (?TemporaryUploadedFile $file, ?Model $record): string {
                                    if (!$file) {
                                        return '';
                                    }
                                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                    $recordName = $record?->name ?? $fileName;
                                    return (string) str('product-gallery-' . str_replace('-', '', Str::slug($recordName)) . '-' . uniqid())->slug() . '.' . $file->getClientOriginalExtension();
                                }),
                        ]),
                        Section::make('Precios')->schema([
                            TextInput::make('price')->label('Precio')->required()->numeric()->prefix('USD'),
                            TextInput::make('sale_price')->label('Precio de Oferta')->numeric()->prefix('USD'),
                            TextInput::make('sku')->label('SKU (Stock Keeping Unit)'),
                        ])->columns(3),
                        Section::make('Inventario')->schema([
                            TextInput::make('stock')->required()->numeric()->default(0),
                        ]),
                    ])->columnSpan(2),

                    Group::make()->schema([
                        Section::make('Estado')->schema([
                            Toggle::make('is_featured')->label('Producto Destacado'),
                        ]),
                        Section::make('Organización')->schema([
                            Select::make('brand_id')->label('Marca')->relationship('brand', 'name')->searchable()->required(),
                            Select::make('categories')->label('Categorías')->relationship('categories', 'name')->multiple()->searchable()->required(),
                        ]),
                        Section::make('Atributos')->schema([
                            Select::make('type')->label('Tipo')->options(ProductType::class)->required(),
                            Select::make('condition')->label('Condición')->options(ProductCondition::class)->required(),
                            TagsInput::make('colors')->label('Colores'),
                        ]),
                        Section::make('Contenido Adicional')->schema([
                            TextInput::make('video_url')->label('URL de Video (YouTube, Vimeo, etc.)'),
                            KeyValue::make('other_content')->label('Otro Contenido (JSON)'),
                            Textarea::make('additional_info')->label('Información Adicional'),
                            TextInput::make('delivery_date_message')->label('Mensaje de Fecha de Entrega'),
                        ]),
                        Section::make('SEO')->schema([
                            TextInput::make('seo_title')->label('Título SEO'),
                            Textarea::make('seo_description')->label('Descripción SEO'),
                            TagsInput::make('seo_keywords')->label('Keywords SEO'),
                        ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imageUrl')->label('Imagen'),
                TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('brand.name')->label('Marca')->sortable(),
                TextColumn::make('price')->label('Precio')->money('usd')->sortable(),
                TextColumn::make('stock')->label('Stock')->numeric()->sortable(),
                IconColumn::make('is_featured')->label('Destacado')->boolean(),
                TextColumn::make('type')->label('Tipo')->searchable()->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
