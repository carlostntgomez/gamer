<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
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
use Filament\Tables\Actions\Action;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Categoría';
    protected static ?string $pluralModelLabel = 'Categorías';
    protected static ?string $navigationLabel = 'Categorías';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('CategoryTabs')
                ->tabs([
                    Tabs\Tab::make('Información Principal')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                                ->helperText('El nombre que se mostrará públicamente.'),

                            Forms\Components\Select::make('parent_id')
                                ->label('Categoría Padre')
                                ->relationship('parent', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Opcional: Asigna una categoría padre')
                                ->helperText('Crea una jerarquía de categorías (ej: Ropa > Camisetas).'),

                            Forms\Components\RichEditor::make('description')
                                ->label('Descripción de la Categoría')
                                ->nullable()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Tabs\Tab::make('Contenido SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Category::class, 'slug', ignoreRecord: true)
                                ->disabled(fn (string $operation): bool => $operation === 'edit')
                                ->helperText('URL amigable. Se recomienda no cambiarla una vez creada para no romper enlaces.'),

                            Forms\Components\TextInput::make('seo_title')
                                ->label('Título SEO')
                                ->maxLength(60)
                                ->nullable()
                                ->helperText('Recomendado: Máximo 60 caracteres. Es el título que aparece en Google.'),

                            Forms\Components\Textarea::make('seo_description')
                                ->label('Descripción SEO')
                                ->maxLength(160)
                                ->rows(3)
                                ->nullable()
                                ->helperText('Recomendado: Máximo 160 caracteres. El resumen que aparece en Google.'),

                            Forms\Components\TagsInput::make('seo_keywords')
                                ->label('Palabras Clave SEO')
                                ->nullable()
                                ->placeholder('Añadir y presionar Enter')
                                ->helperText('Términos de búsqueda relevantes para esta categoría.'),
                        ]),

                    Tabs\Tab::make('Archivos Multimedia')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\FileUpload::make('image_path')
                                ->label('Imagen Principal')
                                ->directory('categories')
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
                                ->helperText('Imagen representativa de la categoría (preferiblemente cuadrada).'),

                            Forms\Components\FileUpload::make('banner_path')
                                ->label('Banner de la Categoría')
                                ->directory('categories')
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
                                ->helperText('Imagen para la cabecera de la página de categoría (preferiblemente horizontal).'),
                        ])->columns(2),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-category.png')),
                ImageColumn::make('banner_path')
                    ->label('Banner')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-category.png')),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copiado'),
                TextColumn::make('parent.name')
                    ->label('Categoría Padre')
                    ->sortable()
                    ->default('—'),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Categoría Padre')
                    ->relationship('parent', 'name')
                    ->placeholder('Todas las categorías'),
            ])
            ->actions([
                Action::make('Ver')
                    ->url(fn (Category $record) => route('category.show', $record->slug))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->iconButton(),
                Tables\Actions\EditAction::make()->iconButton()->color('primary')->modal(),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->modal(),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
