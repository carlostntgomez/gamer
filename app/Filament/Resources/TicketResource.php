<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $modelLabel = 'Ticket de Soporte';
    protected static ?string $pluralModelLabel = 'Tickets de Soporte';
    protected static ?string $navigationLabel = 'Tickets';
    protected static ?string $recordTitleAttribute = 'subject';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('TicketTabs')->tabs([
                    Tabs\Tab::make('Contenido del Ticket')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\TextInput::make('subject')
                                ->label('Asunto')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('message')
                                ->label('Mensaje del Cliente')
                                ->required()
                                ->maxLength(65535)
                                ->fileAttachmentsDirectory('ticket-attachments')
                                ->columnSpanFull(),
                        ]),
                    Tabs\Tab::make('Gestión y Estado')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')->label('Cliente')->searchable()->preload()->required(),
                            Forms\Components\Select::make('assigned_to_id')
                                ->relationship('assignedTo', 'name')
                                ->label('Agente Asignado')
                                ->searchable()
                                ->preload(),
                            Forms\Components\Select::make('status')
                                ->label('Estado')
                                ->options(TicketStatus::class)
                                ->native(false)
                                ->required(),
                            Forms\Components\Select::make('priority')
                                ->label('Prioridad')
                                ->options(TicketPriority::class)
                                ->native(false)
                                ->required(),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Cliente')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('subject')->label('Asunto')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('assignedTo.name')->label('Agente')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Estado')->badge()->sortable(),
                Tables\Columns\TextColumn::make('priority')->label('Prioridad')->badge()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')->relationship('user', 'name')->label('Cliente')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('assigned_to_id')->relationship('assignedTo', 'name')->label('Agente')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('status')->options(TicketStatus::class)->label('Estado'),
                Tables\Filters\SelectFilter::make('priority')->options(TicketPriority::class)->label('Prioridad'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
