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
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Detalles del Descuento')
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->label('Código')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\Select::make('type')
                                    ->label('Tipo de Descuento')
                                    ->options(DiscountType::class)
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('value')
                                    ->label('Valor')
                                    ->numeric()
                                    ->required()
                                    ->suffix(fn (Get $get): string => $get('type') === 'percentage' ? '%' : 'USD'),
                                Forms\Components\TextInput::make('min_amount')
                                    ->label('Cantidad Mínima de Compra')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('USD'),
                                Forms\Components\TextInput::make('max_uses')
                                    ->label('Usos Máximos')
                                    ->numeric()
                                    ->nullable(),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Activo')
                                    ->default(true),
                            ])->columns(2),

                        Forms\Components\Section::make('Fechas de Validez')
                            ->schema([
                                Forms\Components\DateTimePicker::make('starts_at')
                                    ->label('Fecha de Inicio')
                                    ->native(false)
                                    ->nullable(),
                                Forms\Components\DateTimePicker::make('expires_at')
                                    ->label('Fecha de Caducidad')
                                    ->native(false)
                                    ->nullable(),
                            ])->columns(2),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Aplicabilidad')
                            ->schema([
                                Forms\Components\Select::make('applies_to')
                                    ->label('Aplica a')
                                    ->options(DiscountAppliesTo::class)
                                    ->required()
                                    ->live(),
                                Forms\Components\Select::make('product_ids')
                                    ->label('Productos')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(Product::pluck('name', 'id'))
                                    ->visible(fn (Get $get): bool => $get('applies_to') === 'products'),
                                Forms\Components\Select::make('category_ids')
                                    ->label('Categorías')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(Category::pluck('name', 'id'))
                                    ->visible(fn (Get $get): bool => $get('applies_to') === 'categories'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state, Discount $record) => $record->type === DiscountType::Percentage ? "{$state}%" : "{$state} USD"),
                Tables\Columns\TextColumn::make('min_amount')
                    ->label('Mín. Compra')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('uses')
                    ->label('Usos')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_uses')
                    ->label('Máx. Usos')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Activo' : 'Inactivo')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Inicia')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expira')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('applies_to')
                    ->label('Aplica a')
                    ->badge()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo de Descuento')
                    ->options(DiscountType::class),
                Tables\Filters\SelectFilter::make('applies_to')
                    ->label('Aplica a')
                    ->options(DiscountAppliesTo::class),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->trueLabel('Activo')
                    ->falseLabel('Inactivo')
                    ->placeholder('Todos'),
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
