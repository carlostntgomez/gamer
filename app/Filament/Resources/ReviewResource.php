<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Reseña';
    protected static ?string $pluralModelLabel = 'Reseñas';
    protected static ?string $navigationLabel = 'Reseñas';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('ReviewTabs')->tabs([
                Tabs\Tab::make('Contenido de la Reseña')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')->label('Cliente')->searchable()->preload()->required(),
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')->label('Producto')->searchable()->preload()->required(),
                        Forms\Components\Select::make('rating')
                            ->label('Calificación')
                            ->options(array_combine(range(1, 5), array_map(fn($i) => "$i Estrellas", range(1, 5))))
                            ->required()
                            ->helperText('La puntuación que el cliente le dio al producto.'),
                        Forms\Components\RichEditor::make('content')
                            ->label('Comentario del Cliente')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Tabs\Tab::make('Moderación y Estado')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Forms\Components\Toggle::make('is_approved')
                            ->label('Aprobado para su publicación')
                            ->default(true)
                            ->helperText('Solo las reseñas aprobadas serán visibles para los clientes.'),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Fecha de Creación')
                            ->content(fn (?Review $record): string => $record?->created_at?->translatedFormat('d M Y, H:i') ?? '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última Actualización')
                            ->content(fn (?Review $record): string => $record?->updated_at?->translatedFormat('d M Y, H:i') ?? '-'),
                    ])->columns(1),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')->label('Producto')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Cliente')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('rating')->label('Calificación')->sortable()->formatStateUsing(fn(int $state) => str_repeat('⭐', $state)),
                Tables\Columns\IconColumn::make('is_approved')->label('Aprobado')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product')->relationship('product', 'name')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('rating')->label('Calificación')->options(array_combine(range(1, 5), array_map(fn($i) => "$i Estrellas", range(1, 5)))),
                Tables\Filters\TernaryFilter::make('is_approved')->label('Estado de Aprobación'),
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
    { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
