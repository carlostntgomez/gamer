<?php

namespace App\Filament\Resources;

use App\Enums\DiscountAppliesTo;
use App\Enums\DiscountType;
use App\Filament\Resources\DiscountResource\Pages;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Components\Tabs;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Descuento';
    protected static ?string $pluralModelLabel = 'Descuentos';
    protected static ?string $navigationLabel = 'Descuentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('DiscountTabs')->tabs([
                    Tabs\Tab::make('Detalles del Descuento')
                        ->icon('heroicon-o-ticket')
                        ->schema([
                            Forms\Components\TextInput::make('code')
                                ->label('Código del Descuento')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->helperText('El código que los clientes usarán en el checkout.'),
                            Forms\Components\Select::make('type')
                                ->label('Tipo de Descuento')
                                ->options(DiscountType::class)
                                ->required()
                                ->live(),
                            Forms\Components\TextInput::make('value')
                                ->label('Valor del Descuento')
                                ->numeric()
                                ->required()
                                ->suffix(fn (Get $get): string => $get('type') === 'percentage' ? '%' : 'USD')
                                ->helperText('El valor fijo o el porcentaje a descontar.'),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Activar Descuento')
                                ->default(true)
                                ->helperText('Solo los descuentos activos pueden ser utilizados.'),
                        ])->columns(2),

                    Tabs\Tab::make('Condiciones y Límites')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Forms\Components\TextInput::make('min_amount')
                                ->label('Cantidad Mínima de Compra')
                                ->numeric()
                                ->nullable()
                                ->prefix('USD')
                                ->helperText('El carrito debe alcanzar este monto para que el descuento aplique.'),
                            Forms\Components\TextInput::make('max_uses')
                                ->label('Límite de Usos Totales')
                                ->numeric()
                                ->nullable()
                                ->helperText('El número máximo de veces que este descuento puede ser usado en total.'),
                            Forms\Components\DateTimePicker::make('starts_at')
                                ->label('Fecha de Inicio')
                                ->native(false)
                                ->nullable(),
                            Forms\Components\DateTimePicker::make('expires_at')
                                ->label('Fecha de Caducidad')
                                ->native(false)
                                ->nullable(),
                        ])->columns(2),

                    Tabs\Tab::make('Aplicabilidad')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->schema([
                            Forms\Components\Select::make('applies_to')
                                ->label('Aplica a')
                                ->options(DiscountAppliesTo::class)
                                ->required()
                                ->live()
                                ->helperText('Define si el descuento es para todo el pedido, productos o categorías específicas.'),
                            Forms\Components\Select::make('product_ids')
                                ->label('Productos Específicos')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->options(Product::pluck('name', 'id'))
                                ->visible(fn (Get $get): bool => $get('applies_to') === 'products'),
                            Forms\Components\Select::make('category_ids')
                                ->label('Categorías Específicas')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->options(Category::pluck('name', 'id'))
                                ->visible(fn (Get $get): bool => $get('applies_to') === 'categories'),
                        ])->columns(1),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Código')->searchable()->sortable()->copyable(),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->badge()->sortable(),
                Tables\Columns\TextColumn::make('value')->label('Valor')->sortable()->formatStateUsing(fn ($state, Discount $record) => $record->type === DiscountType::Percentage ? "{$state}%" : "{$state} USD"),
                Tables\Columns\TextColumn::make('uses')->label('Usos')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('is_active')->label('Estado')->badge()->formatStateUsing(fn (bool $state): string => $state ? 'Activo' : 'Inactivo')->color(fn (bool $state): string => $state ? 'success' : 'danger')->sortable(),
                Tables\Columns\TextColumn::make('starts_at')->label('Inicia')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('expires_at')->label('Expira')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->label('Tipo de Descuento')->options(DiscountType::class),
                Tables\Filters\SelectFilter::make('applies_to')->label('Aplica a')->options(DiscountAppliesTo::class),
                Tables\Filters\TernaryFilter::make('is_active')->label('Estado')->trueLabel('Activo')->falseLabel('Inactivo'),
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
                Tables\Actions\CreateAction::make()->modal(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
        ];
    }
}
