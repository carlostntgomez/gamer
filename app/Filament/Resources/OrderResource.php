<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
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
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Cliente y Direcciones')
                        ->description('Información del cliente y direcciones de envío/facturación.')
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->label('Cliente')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->helperText('Selecciona un cliente o déjalo en blanco para un invitado.'),

                            Forms\Components\Select::make('shipping_address_id')
                                ->label('Dirección de Envío')
                                ->options(fn (Forms\Get $get) => Address::where('user_id', $get('user_id'))->pluck('full_address', 'id'))
                                ->searchable()
                                ->preload(),

                            Forms\Components\Select::make('billing_address_id')
                                ->label('Dirección de Facturación')
                                ->options(fn (Forms\Get $get) => Address::where('user_id', $get('user_id'))->pluck('full_address', 'id'))
                                ->searchable()
                                ->preload(),
                        ])->columns(2),

                    Forms\Components\Section::make('Items del Pedido')
                        ->headerActions([
                            Forms\Components\Actions\Action::make('reset')
                                ->label('Reiniciar Items')
                                ->requiresConfirmation()
                                ->color('danger')
                                ->action(fn (Forms\Set $set) => $set('orderItems', [])),
                        ])
                        ->schema([
                            Forms\Components\Repeater::make('orderItems')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make('product_id')
                                        ->label('Producto')
                                        ->relationship('product', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->columnSpan(4)
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                                            $product = Product::find($state);
                                            if ($product) {
                                                $set('unit_price', $product->price);
                                            }
                                        }),
                                    Forms\Components\TextInput::make('quantity')->label('Cantidad')->numeric()->required()->default(1)->minValue(1)->columnSpan(2),
                                    Forms\Components\TextInput::make('unit_price')->label('Precio Unitario')->numeric()->required()->prefix('COP')->columnSpan(2),
                                ])
                                ->columns(8)
                                ->live()
                                ->afterStateUpdated(self::updateTotal())
                                ->reorderable(false)
                                ->defaultItems(0),
                        ]),

                ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Resumen del Pedido')
                        ->schema([
                            Forms\Components\Placeholder::make('uuid')->label('UUID')->content(fn ($record) => $record?->uuid ?? '-'),
                            Forms\Components\Select::make('status')->label('Estado del Pedido')->options(OrderStatus::class)->required(),
                            Forms\Components\TextInput::make('total')->label('Total del Pedido')->numeric()->prefix('COP')->readOnly(),
                        ]),
                    
                    Forms\Components\Section::make('Notas Internas')
                        ->schema([
                            Forms\Components\Textarea::make('notes')->label('Notas del Pedido')->rows(4)->helperText('Notas internas, no visibles para el cliente.'),
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
                Tables\Columns\TextColumn::make('created_at')->label('Fecha del Pedido')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Estado')->options(OrderStatus::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info')->modal(),
                Tables\Actions\EditAction::make()->iconButton()->color('primary')->modal(),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]),
            ])
            ->headerActions([
                // Se elimina CreateAction ya que los pedidos deben generarse desde el frontend
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    { return []; }

    public static function getPages(): array
    { return [ 'index' => Pages\ListOrders::route('/') ]; }

    private static function updateTotal(): callable
    {
        return function (Forms\Get $get, Forms\Set $set) {
            $items = $get('orderItems');
            $total = 0;
            foreach ($items as $item) {
                if (is_numeric($item['quantity']) && is_numeric($item['unit_price'])) {
                    $total += $item['quantity'] * $item['unit_price'];
                }
            }
            $set('total', number_format($total, 2, '.', ''));
        };
    }
}
