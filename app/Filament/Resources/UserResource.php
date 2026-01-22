<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Tabs;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('UserTabs')->tabs([
                    Tabs\Tab::make('Información de la Cuenta')
                        ->icon('heroicon-o-user-circle')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre Completo')
                                ->icon('heroicon-o-user')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->label('Correo Electrónico')
                                ->icon('heroicon-o-envelope')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Forms\Components\TextInput::make('password')
                                ->label('Contraseña')
                                ->icon('heroicon-o-key')
                                ->password()
                                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $context): bool => $context === 'create')
                                ->helperText('Dejar en blanco para no cambiar la contraseña actual.'),
                        ])->columns(2),

                    Tabs\Tab::make('Detalles Adicionales')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('phone')
                                ->label('Teléfono')
                                ->icon('heroicon-o-phone')
                                ->tel(),
                            Forms\Components\Toggle::make('marketing_opt_in')
                                ->label('Suscrito a Marketing')
                                ->helperText('Indica si el usuario acepta recibir correos de marketing.'),
                            Forms\Components\RichEditor::make('customer_notes')
                                ->label('Notas Internas del Usuario')
                                ->columnSpanFull(),
                        ])->columns(1),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (User $record): string => $record->email),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->icon('heroicon-o-phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Nº Pedidos')
                    ->sortable()
                    ->badge(),
                Tables\Columns\IconColumn::make('marketing_opt_in')
                    ->label('Suscrito')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('marketing_opt_in')
                    ->label('Suscrito a Marketing'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('gray')->tooltip('Ver detalles del usuario'),
                Tables\Actions\EditAction::make()->iconButton()->color('warning')->tooltip('Editar usuario'),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger')->tooltip('Eliminar usuario'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Información del Usuario')->schema([
                Infolists\Components\TextEntry::make('name')->label('Nombre')->weight('bold'),
                Infolists\Components\TextEntry::make('email')->label('Correo Electrónico')->icon('heroicon-o-envelope'),
                Infolists\Components\TextEntry::make('phone')->label('Teléfono')->icon('heroicon-o-phone'),
            ])->columns(2),

            Infolists\Components\Section::make('Estado y Preferencias')->schema([
                Infolists\Components\IconEntry::make('marketing_opt_in')->label('Suscrito a Marketing')->boolean(),
                Infolists\Components\TextEntry::make('created_at')->label('Fecha de Registro')->dateTime('d/m/Y H:i'),
            ])->columns(2),

            Infolists\Components\Section::make('Notas Internas')->schema([
                Infolists\Components\TextEntry::make('customer_notes')->html()->columnSpanFull(),
            ])->collapsible(),
        ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\AddressesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }

    public static function getModalWidth(): string
    {
        return '4xl';
    }
}
