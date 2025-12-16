<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Reseña';
    protected static ?string $pluralModelLabel = 'Reseñas';
    protected static ?string $navigationLabel = 'Reseñas';
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles de la Reseña')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Usuario')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->label('Producto')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('rating')
                            ->label('Calificación')
                            ->options([
                                1 => '1 Estrella',
                                2 => '2 Estrellas',
                                3 => '3 Estrellas',
                                4 => '4 Estrellas',
                                5 => '5 Estrellas',
                            ])
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5),
                        Forms\Components\Toggle::make('is_approved')
                            ->label('Aprobado')
                            ->default(false),
                        Forms\Components\Textarea::make('content')
                            ->label('Contenido de la Reseña')
                            ->required()
                            ->maxLength(65535)
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Calificación')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state)), // Display stars
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Aprobado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('content')
                    ->label('Reseña')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->relationship('product', 'name')
                    ->label('Filtrar por Producto')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Filtrar por Usuario')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Filtrar por Calificación')
                    ->options([
                        1 => '1 Estrella',
                        2 => '2 Estrellas',
                        3 => '3 Estrellas',
                        4 => '4 Estrellas',
                        5 => '5 Estrellas',
                    ]),
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Estado de Aprobación')
                    ->trueLabel('Aprobado')
                    ->falseLabel('No Aprobado')
                    ->placeholder('Todos'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
