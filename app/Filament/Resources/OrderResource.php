<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Pedido';
    protected static ?string $pluralModelLabel = 'Pedidos';
    protected static ?string $navigationLabel = 'Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Detalles del Pedido')
                            ->schema([
                                Forms\Components\TextInput::make('uuid')
                                    ->label('UUID del Pedido')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->maxLength(255),
                                Forms\Components\Select::make('user_id')
                                    ->label('Usuario')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText('Dejar en blanco para pedidos de invitados.'),
                                Forms\Components\Select::make('status')
                                    ->label('Estado')
                                    ->options(OrderStatus::class)
                                    ->required(),
                                Forms\Components\TextInput::make('total')
                                    ->label('Total del Pedido')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->helperText('Calculado automáticamente por los ítems del pedido.'),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Notas del Pedido')
                                    ->rows(3)
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Direcciones')
                            ->schema([
                                Forms\Components\Select::make('shipping_address_id')
                                    ->label('Dirección de Envío')
                                    ->relationship(
                                        'shippingAddress',
                                        'address_line_1',
                                        fn (Builder $query) => $query->where('type', 'shipping')
                                    )
                                    ->getOptionLabelFromRecordUsing(fn (Address $record) => "{$record->address_line_1}, {$record->city}, {$record->state}")
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                                Forms\Components\Select::make('billing_address_id')
                                    ->label('Dirección de Facturación')
                                    ->relationship(
                                        'billingAddress',
                                        'address_line_1',
                                        fn (Builder $query) => $query->where('type', 'billing')
                                    )
                                    ->getOptionLabelFromRecordUsing(fn (Address $record) => "{$record->address_line_1}, {$record->city}, {$record->state}")
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                            ])->columns(2),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID del Pedido')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable()
                    ->default('Invitado'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shippingAddress.address_line_1')
                    ->label('Dirección de Envío')
                    ->limit(30)
                    ->tooltip(fn (Order $record): string => $record->shippingAddress ? $record->shippingAddress->full_address : 'N/A')
                    ->searchable(),
                Tables\Columns\TextColumn::make('billingAddress.address_line_1')
                    ->label('Dirección de Facturación')
                    ->limit(30)
                    ->tooltip(fn (Order $record): string => $record->billingAddress ? $record->billingAddress->full_address : 'N/A')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->label('Filtrar por Usuario')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(OrderStatus::class),
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
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
