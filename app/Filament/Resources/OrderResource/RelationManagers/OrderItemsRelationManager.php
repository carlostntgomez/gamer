<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $product = Product::find($state);
                        if ($product) {
                            $set('price', $product->price);
                        }
                    }),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Get $get, Set $set) => $set('subtotal', $state * $get('price'))),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->prefix('USD')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Get $get, Set $set) => $set('subtotal', $state * $get('quantity'))),
                Forms\Components\TextInput::make('subtotal')
                    ->numeric()
                    ->prefix('USD')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                Tables\Columns\ImageColumn::make('product.image_url')
                    ->label('Imagen')
                    ->circular(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto')
                    ->sortable()
                    ->searchable()
                    ->url(fn ($record) => route('filament.admin.resources.products.edit', ['record' => $record->product_id]))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio Unitario')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('usd')
                    ->getStateUsing(fn ($record) => $record->quantity * $record->price),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(fn () => $this->updateOrderTotal($this->getOwnerRecord())),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(fn () => $this->updateOrderTotal($this->getOwnerRecord())),
                Tables\Actions\DeleteAction::make()
                    ->after(fn () => $this->updateOrderTotal($this->getOwnerRecord())),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(fn () => $this->updateOrderTotal($this->getOwnerRecord())),
                ]),
            ]);
    }

    protected function updateOrderTotal(Model $order)
    {
        $total = $order->orderItems()->sum('price');
        $order->update(['total' => $total]);
    }
}
