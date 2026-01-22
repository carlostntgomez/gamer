<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Filament\Resources\AuthorResource\RelationManagers;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $modelLabel = 'Autor';
    protected static ?string $pluralModelLabel = 'Autores';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información Personal')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('bio')
                        ->label('Biografía')
                        ->columnSpanFull(),
                ])->columns(2),

                Section::make('Avatar')->schema([
                    Forms\Components\FileUpload::make('avatar')
                        ->label('Avatar')
                        ->directory('temp-uploads') // Sube a una carpeta temporal
                        ->disk('public')
                        ->avatar() // Configura el editor para avatares (circular)
                        ->imageResizeTargetWidth('400') // Redimensiona a 400px
                        ->imageResizeTargetHeight('400') // Redimensiona a 400px
                        ->helperText('La imagen se recortará a 400x400 y se convertirá a WebP.'),
                ])->columns(1),
                
                Section::make('Social')->schema([
                    Forms\Components\TextInput::make('github')
                        ->label('GitHub')
                        ->url()
                        ->maxLength(255),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->disk('public')->label('Avatar')->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('posts_count')->counts('posts')->label('Artículos'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
        ];
    }
}
