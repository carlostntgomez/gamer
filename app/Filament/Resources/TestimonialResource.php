<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Testimonio';
    protected static ?string $pluralModelLabel = 'Testimonios';
    protected static ?string $navigationLabel = 'Testimonios';
    protected static ?string $recordTitleAttribute = 'author_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Detalles del Testimonio')
                            ->schema([
                                Forms\Components\TextInput::make('author_name')
                                    ->label('Nombre del Autor')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('author_title')
                                    ->label('Cargo/Título del Autor')
                                    ->maxLength(255)
                                    ->nullable(),
                                RichEditor::make('content')
                                    ->label('Contenido del Testimonio')
                                    ->required()
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                Select::make('rating')
                                    ->label('Calificación')
                                    ->options([
                                        1 => '1 Estrella',
                                        2 => '2 Estrellas',
                                        3 => '3 Estrellas',
                                        4 => '4 Estrellas',
                                        5 => '5 Estrellas',
                                    ])
                                    ->numeric()
                                    ->nullable()
                                    ->columnSpan(1),
                                Toggle::make('is_published')
                                    ->label('Publicado')
                                    ->default(false)
                                    ->columnSpan(1),
                            ])->columns(2),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_title')
                    ->label('Cargo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('content')
                    ->label('Contenido')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Calificación')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn (?int $state): string => $state ? str_repeat('⭐', $state) : 'N/A'),
                IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Calificación')
                    ->options([
                        1 => '1 Estrella',
                        2 => '2 Estrellas',
                        3 => '3 Estrellas',
                        4 => '4 Estrellas',
                        5 => '5 Estrellas',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Estado de Publicación')
                    ->trueLabel('Publicado')
                    ->falseLabel('Borrador')
                    ->placeholder('Todos'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('info'),
                Tables\Actions\EditAction::make()->iconButton()->color('primary'),
                Tables\Actions\DeleteAction::make()->iconButton()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
