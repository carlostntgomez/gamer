<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?string $modelLabel = 'Reseña';
    protected static ?string $pluralModelLabel = 'Reseñas';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Contenido de la Reseña')->schema([
                    Forms\Components\Select::make('product_id')
                        ->label('Producto')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('user_id')
                        ->label('Cliente')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('title')
                        ->label('Título de la reseña')
                        ->required(),
                    Forms\Components\Textarea::make('content')
                        ->label('Contenido')
                        ->required()
                        ->columnSpanFull(),
                ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Calificación y Estado')->schema([
                    Forms\Components\Select::make('rating')
                        ->label('Calificación')
                        ->options(array_combine(range(1, 5), array_map(fn($i) => "$i " . Str::plural('Estrella', $i), range(1, 5))))
                        ->required(),
                    Forms\Components\Toggle::make('is_approved')
                        ->label('Aprobado')
                        ->helperText('Solo las reseñas aprobadas serán visibles en la tienda.')
                        ->default(true),
                ]),
                Forms\Components\Section::make()->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Enviado el')
                        ->content(fn (?Review $record): string => $record?->created_at?->translatedFormat('d M Y, H:i') ?? '-')
                        ->hidden(fn (?Review $record) => $record === null),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Última modificación')
                        ->content(fn (?Review $record): string => $record?->updated_at?->translatedFormat('d M Y, H:i') ?? '-')
                        ->hidden(fn (?Review $record) => $record === null || $record->updated_at === null),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('product.main_image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->defaultImageUrl(url('/images/product-placeholder.png'))
                    ->square(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto y Reseña')
                    ->description(fn (Review $record): string => Str::limit($record->title, 40))
                    ->weight('bold')
                    ->searchable(['name', 'title'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Cliente'),
                Tables\Columns\IconColumn::make('rating')
                    ->label('Calificación')
                    ->icons(fn (Review $record) => array_fill(0, $record->rating, 'heroicon-s-star'))
                    ->colors(fn (Review $record) => array_fill(0, $record->rating, match ($record->rating) {
                        1 => 'danger',
                        2, 3 => 'warning',
                        4, 5 => 'success',
                        default => 'gray',
                    })),
                Tables\Columns\TextColumn::make('content')
                    ->label('Contenido')
                    ->searchable()
                    ->lineClamp(2)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Aprobado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // ... (filtros sin cambios)
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('gray'),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Aprobar seleccionadas')
                        ->action(fn (Collection $records) => $records->each->update(['is_approved' => true]))
                        ->icon('heroicon-o-check-circle'),
                    Tables\Actions\BulkAction::make('unapprove')
                        ->label('Desaprobar seleccionadas')
                        ->action(fn (Collection $records) => $records->each->update(['is_approved' => false]))
                        ->icon('heroicon-o-x-circle'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Reseña del Producto')->schema([
                Infolists\Components\TextEntry::make('product.name')
                    ->label('Producto')
                    ->badge(),
                Infolists\Components\TextEntry::make('user.name')->label('Cliente'),
                Infolists\Components\IconEntry::make('rating')
                    ->label('Calificación')
                    ->icons(fn (Review $record) => array_fill(0, $record->rating, 'heroicon-s-star'))
                    ->colors(fn (Review $record) => array_fill(0, $record->rating, match ($record->rating) {
                        1 => 'danger',
                        2, 3 => 'warning',
                        4, 5 => 'success',
                        default => 'gray',
                    })),
                Infolists\Components\IconEntry::make('is_approved')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Infolists\Components\TextEntry::make('content')
                    ->label('Contenido')
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
