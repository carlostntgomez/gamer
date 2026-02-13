<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Number;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\ShippingZone;
use Closure;
use Filament\Forms\Components;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $recordTitleAttribute = 'uuid';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Components\Tabs::make('OrderTabs')->tabs([
                Components\Tabs\Tab::make('Detalles Generales')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Components\TextInput::make('uuid')->label('UUID de Pedido')->disabled()->required()->default(fn() => \Illuminate\Support\Str::uuid()->toString()),
                        Components\Select::make('payment_method')->label('Método de Pago')->options(PaymentMethod::class)->required()->native(false),
                        Hidden::make('currency')->default('cop')->required(),
                        Components\ToggleButtons::make('status')->label('Estado')->options(OrderStatus::class)->inline()->required()->default(OrderStatus::Pending),
                        Components\DatePicker::make('created_at')->label('Fecha de Creación')->default(now())->disabled()->dehydrated(),
                    ])->columns(2),

                Components\Tabs\Tab::make('Ítems del Pedido')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        Section::make('Productos del Pedido')
                            ->schema([
                                Repeater::make('orderItems')
                                    ->relationship()
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('Producto')
                                            ->relationship('product', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                $product = Product::find($state);
                                                $set('unit_price', $product ? $product->price : 0);
                                                self::updateTotals($get, $set);
                                            })
                                            ->afterStateHydrated(function ($state, Set $set) {
                                                $product = Product::find($state);
                                                $set('unit_price', $product ? $product->price : 0);
                                            })
                                            ->columnSpan(4),
                                        TextInput::make('quantity')
                                            ->label('Cantidad')
                                            ->numeric()
                                            ->required()
                                            ->minValue(1)
                                            ->default(1)
                                            ->reactive()
                                            ->afterStateUpdated(fn(Get $get, Set $set) => self::updateTotals($get, $set))
                                            ->columnSpan(4),
                                        TextInput::make('unit_price')
                                            ->label('Precio Unitario')
                                            ->numeric()
                                            ->required()
                                            ->disabled()
                                            ->dehydrated()
                                            ->columnSpan(4),
                                    ])
                                    ->columns(12)
                                    ->addable(true)
                                    ->deletable(true)
                                    ->reactive()
                                    ->afterStateUpdated(fn(Get $get, Set $set) => self::updateTotals($get, $set))
                                    ->afterStateHydrated(fn (Get $get, Set $set) => self::updateTotals($get, $set))
                                    ->itemLabel(fn (array $state): ?string => Product::find($state['product_id'])?->name ?? null),
                            ]),

                        Fieldset::make('Totales del Pedido')
                            ->schema([
                                TextInput::make('shipping_cost')
                                    ->label('Costo de Envío')
                                    ->numeric()
                                    ->prefix('COP')
                                    ->reactive()
                                    ->afterStateUpdated(fn(Get $get, Set $set) => self::updateTotals($get, $set))
                                    ->default(0),
                                Placeholder::make('subtotal')
                                    ->label('Subtotal')
                                    ->content(fn (Get $get): string => Number::currency($get('subtotal') ?? 0, 'COP')),
                                Placeholder::make('total')
                                    ->label('Total General')
                                    ->content(fn (Get $get): string => Number::currency($get('total') ?? 0, 'COP')),
                            ])->columns(3),

                        Hidden::make('subtotal')->default(0),
                        Hidden::make('total')->default(0),
                    ]),

                Components\Tabs\Tab::make('Direcciones')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Section::make('Dirección de Envío')
                            ->relationship('shippingAddress')
                            ->schema([
                                TextInput::make('first_name')->label('Nombres')->required(),
                                TextInput::make('last_name')->label('Apellidos')->required(),
                                TextInput::make('address')->label('Dirección')->required(),
                                TextInput::make('apartment')->label('Apto/Interior (Opcional)'),
                                TextInput::make('neighborhood')->label('Barrio')->required(),
                                TextInput::make('city')->label('Ciudad')->required(),
                                TextInput::make('state')->label('Departamento')->required(),
                                Select::make('country')->label('País')->options(self::getCountries())->searchable()->native(false)->required(),
                            ])->columns(2),

                        Section::make('Dirección de Facturación')
                            ->relationship('billingAddress') 
                            ->schema([
                                TextInput::make('first_name')->label('Nombres')->required(),
                                TextInput::make('last_name')->label('Apellidos')->required(),
                                TextInput::make('address')->label('Dirección')->required(),
                                TextInput::make('apartment')->label('Apto/Interior (Opcional)'),
                                TextInput::make('neighborhood')->label('Barrio')->required(),
                                TextInput::make('city')->label('Ciudad')->required(),
                                TextInput::make('state')->label('Departamento')->required(),
                                Select::make('country')->label('País')->options(self::getCountries())->searchable()->native(false)->required(),
                                TextInput::make('phone')->label('Teléfono')->required(),
                                TextInput::make('email')->label('Email')->email()->required(),
                            ])->columns(2),
                    ])->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID de Pedido')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('shippingAddress.first_name')
                    ->label('Cliente')
                    ->formatStateUsing(fn (Order $record) => $record->shippingAddress?->first_name . ' ' . $record->shippingAddress?->last_name)
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderItems.count')
                    ->label('Cant. Productos')
                    ->counts('orderItems')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (OrderStatus $state): string => match ($state) {
                        OrderStatus::Pending => 'warning',
                        OrderStatus::Processing => 'info',
                        OrderStatus::Shipped => 'success',
                        OrderStatus::Delivered => 'primary',
                        OrderStatus::Cancelled => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (OrderStatus $state): string => $state->getLabel() ?? $state->value)
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Método de Pago')
                    ->badge()
                    ->color(fn (PaymentMethod $state): string => match ($state->value) {
                        'bank_transfer' => 'info',
                        'cash_on_delivery' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (PaymentMethod $state): string => $state->getLabel() ?? $state->value)
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('shipping_cost')
                    ->label('Costo de Envío')
                    ->money('COP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('COP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Pedido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filtrar por Estado')
                    ->options(OrderStatus::class)
                    ->searchable(),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Filtrar por Método de Pago')
                    ->options(PaymentMethod::class)
                    ->searchable(),
            ])
            ->actions([
                Action::make('Ver Recibo')
                    ->url(fn (Order $record): string => '/order-complete/' . $record->uuid)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->iconButton(),
                Tables\Actions\ViewAction::make()->iconButton()->color('info')->modal(),
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
            RelationManagers\OrderStatusHistoryRelationManager::class,
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['uuid', 'shippingAddress.first_name', 'shippingAddress.last_name', 'shippingAddress.email'];
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $items = $get('orderItems') ?? [];

        $subtotal = collect($items)->reduce(function ($carry, $item) {
            $quantity = is_numeric($item['quantity']) ? $item['quantity'] : 0;
            $unitPrice = is_numeric($item['unit_price']) ? $item['unit_price'] : 0;
            return $carry + ($quantity * $unitPrice);
        }, 0);

        $shippingPrice = is_numeric($get('shipping_cost')) ? $get('shipping_cost') : 0;

        $total = $subtotal + $shippingPrice;

        $set('subtotal', round($subtotal, 2));
        $set('total', round($total, 2));
    }

    public static function getShippingPrice(?string $country, float $subtotal): float
    {
        return 0;
    }

    private static function getCountries(): array
    {
        return [
            'CO' => 'Colombia',
            'US' => 'United States',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['billingAddress', 'shippingAddress']);
    }
}
