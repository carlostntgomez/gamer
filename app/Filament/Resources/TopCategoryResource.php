<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopCategoryResource\Pages;
use App\Models\TopCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TopCategoryResource extends Resource
{
    protected static ?string $model = TopCategory::class;

    protected static ?string $modelLabel = 'Categoría Superior';

    protected static ?string $pluralModelLabel = 'Categorías Superiores';

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Página de Inicio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('name'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Categoría'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('top-categories')
                    ->imageEditor()
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->imagePreviewHeight('150')
                    ->required()
                    ->label('Imagen')
                    ->saveAs('webp'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->width(100)
                    ->height('auto')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre de la Categoría')
                    ->default('Categoría Eliminada'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->modalHeading('Editar Categoría Superior'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->modalHeading('Eliminar Categoría Superior'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order');
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
            'index' => Pages\ListTopCategories::route('/'),
        ];
    }
}
