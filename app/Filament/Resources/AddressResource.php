<?php

namespace App\Filament\Resources;

use App\Enums\AddressType;
use App\Filament\Resources\AddressResource\Pages;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $modelLabel = 'Dirección';
    protected static ?string $pluralModelLabel = 'Direcciones';
    protected static ?string $navigationLabel = 'Direcciones';
    protected static ?string $recordTitleAttribute = 'address_line_1';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Información del Destinatario')
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')->label('Cliente')->searchable()->preload()
                                ->helperText('Opcional. Asociar esta dirección a un cliente existente.'),
                            Forms\Components\TextInput::make('first_name')->label('Nombre')->required(),
                            Forms\Components\TextInput::make('last_name')->label('Apellidos')->required(),
                            Forms\Components\TextInput::make('phone')->label('Teléfono')->tel(),
                        ])->columns(2),

                    Forms\Components\Section::make('Detalles de la Dirección Postal')
                        ->schema([
                            Forms\Components\TextInput::make('address_line_1')->label('Línea de Dirección 1')->required(),
                            Forms\Components\TextInput::make('address_line_2')->label('Línea de Dirección 2'),
                            Forms\Components\TextInput::make('city')->label('Ciudad')->required(),
                            Forms\Components\TextInput::make('state')->label('Estado / Provincia')->required(),
                            Forms\Components\TextInput::make('zip_code')->label('Código Postal')->required(),
                            Forms\Components\TextInput::make('country')->label('País')->required(),
                        ])->columns(2),
                ])
                ->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Estado y Metadatos')
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->label('Tipo de Dirección')
                                ->options(AddressType::class)
                                ->required(),
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Fecha de Creación')
                                ->content(fn(?Address $record): string => $record?->created_at?->translatedFormat('d M Y, H:i') ?? '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Última Actualización')
                                ->content(fn(?Address $record): string => $record?->updated_at?->translatedFormat('d M Y, H:i') ?? '-'),
                        ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Cliente')->default('Invitado')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('full_name')->label('Nombre Completo')->searchable(query: function ($query, $search) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                }),
                Tables\Columns\TextColumn::make('type')->badge()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('full_address')->label('Dirección Completa')->searchable(query: function ($query, $search) {
                    $query->whereRaw("CONCAT(address_line_1, ', ', city, ', ', state) LIKE ?", ["%{$search}%"]);
                }),
                Tables\Columns\TextColumn::make('country')->label('País')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado el')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')->relationship('user', 'name')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('type')->options(AddressType::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAddresses::route('/'),
        ];
    }
}
