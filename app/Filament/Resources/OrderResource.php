<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Pedido';
    protected static ?string $pluralModelLabel = 'Pedidos';
    protected static ?string $navigationLabel = 'Pedidos';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Tabs::make('OrderTabs')->tabs([
                    Forms\Components\Tabs\Tab::make('Pedido y Cliente')
                        ->icon('heroicon-o-user-circle')
                        ->schema([
                            Forms\Components\Section::make('Información del Cliente')
                                ->schema([
                                    Forms\Components\Select::make('user_id')
                                        ->relationship('user', 'name')->label('Cliente')->searchable()->preload()->live()
                                        ->helperText('Selecciona el cliente para ver sus direcciones.'),
                                    Forms\Components\Select::make('shipping_address_id')
                                        ->label('Dirección de Envío')
                                        ->options(fn (Forms\Get $get) => Address::where('user_id', $get('user_id'))->pluck('full_address', 'id'))
                                        ->searchable()->preload()->required(),
                                    Forms\Components\Select::make('billing_address_id')
                                        ->label('Dirección de Facturación')
                                        ->options(fn (Forms\Get $get) => Address::where('user_id', $get('user_id'))->pluck('full_address', 'id'))
                                        ->searchable()->preload()->required(),
                                ])->columns(2),
                        ]),

                    Forms\Components\Tabs\Tab::make('Artículos del Pedido')
                        ->icon('heroicon-o-cube')
                        ->schema([
                            Forms\Components\Repeater::make('orderItems')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make('product_id')->label('Producto')
                                        ->relationship('product', 'name')
                                        ->searchable()->preload()->required()->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                                            $product = Product::find($state);
                                            if ($product) {
                                                $set('unit_price', $product->price);
                                            }
                                        }),
                                    Forms\Components\TextInput::make('quantity')->label('Cantidad')->numeric()->required()->default(1)->minValue(1),
                                    Forms\Components\TextInput::make('unit_price')->label('Precio Unitario')->numeric()->required()->prefix('COP'),
                                ])
                                ->reorderable(false)->defaultItems(1)->columns(3)->live()
                                ->afterStateUpdated(self::updateTotal()),
                        ]),
                ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Estado y Resumen')
                    ->schema([
                        Forms\Components\Select::make('status')->label('Estado')->options(OrderStatus::class)->required()->default(OrderStatus::PENDING),
                        Forms\Components\TextInput::make('total')->label('Total del Pedido')->numeric()->prefix('COP')->readOnly(),
                        Forms\Components\Textarea::make('notes')->label('Notas Internas')->rows(3)->helperText('No visibles para el cliente.'),
                    ]),
                Forms\Components\Section::make('Metadatos')
                    ->schema([
                        Forms\Components\Placeholder::make('uuid')->label('UUID')->content(fn ($record) => $record?->uuid ?? '-')->disabled(),
                        Forms\Components\Placeholder::make('created_at')->label('Creado')->content(fn ($record) => $record?->created_at?->diffForHumans() ?? '-')->disabled(),
                        Forms\Components\Placeholder::make('updated_at')->label('Actualizado')->content(fn ($record) => $record?->updated_at?->diffForHumans() ?? '-')->disabled(),
                    ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')->label('ID Pedido')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('user.name')->label('Cliente')->searchable()->sortable()->default('Invitado'),
                Tables\Columns\TextColumn::make('status')->label('Estado')->badge()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('total')->label('Total')->money('cop')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha Pedido')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Estado')->options(OrderStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
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
            'index' => Pages\ListOrders::route('/'),
        ];
    }

    private static function updateTotal(): Closure
    {
        return function (Forms\Get $get, Forms\Set $set) {
            $items = $get('orderItems');
            $total = collect($items)->reduce(function ($carry, $item) {
                return $carry + ($item['quantity'] * $item['unit_price']);
            }, 0);
            $set('total', number_format($total, 2, '.', ''));
        };
    }
}
