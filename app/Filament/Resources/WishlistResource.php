<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WishlistResource\Pages;
use App\Models\Wishlist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class WishlistResource extends Resource
{
    protected static ?string $model = Wishlist::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $modelLabel = 'Elemento de Lista de Deseos';
    protected static ?string $pluralModelLabel = 'Listas de Deseos';
    protected static ?string $navigationLabel = 'Listas de Deseos';

    public static function getRecordTitle(?Model $record): string
    {
        return 'Elemento de Deseos #' . $record?->id;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Detalles del Elemento')
                        ->description('Selecciona el cliente y el producto para crear un nuevo elemento en la lista de deseos.')
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')->label('Cliente')->searchable()->preload()->required(),
                            Forms\Components\Select::make('product_id')
                                ->relationship('product', 'name')->label('Producto')->searchable()->preload()->required(),
                        ])->columns(2),
                ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Metadatos')
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Fecha de Creación')
                                ->content(fn(?Wishlist $record): string => $record?->created_at?->translatedFormat('d M Y, H:i') ?? '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Última Actualización')
                                ->content(fn(?Wishlist $record): string => $record?->updated_at?->translatedFormat('d M Y, H:i') ?? '-'),
                        ]),
                ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuario')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('product.name')->label('Producto')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Agregado el')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')->relationship('user', 'name')->label('Usuario')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('product_id')->relationship('product', 'name')->label('Producto')->searchable()->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWishlists::route('/'),
        ];
    }
}
