<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle')
                    ->label('Subtítulo')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Imagen')
                    ->image()
                    ->directory('offers')
                    ->required()
                    ->mutateDehydratedStateUsing(function ($state, $get) {
                        if (!$state) {
                            return null;
                        }

                        $title = $get('title');
                        $filename = Str::slug($title) . '-' . uniqid() . '.webp';
                        $path = 'offers/' . $filename;

                        $image = Image::read(storage_path('app/public/' . $state));
                        $image->encode(new \Intervention\Image\Encoders\WebpEncoder(quality: 80));
                        Storage::disk('public')->put($path, (string) $image);
                        
                        // Eliminar el archivo temporal
                        Storage::disk('public')->delete($state);

                        return $path;
                    }),
                Forms\Components\TextInput::make('cta_text')
                    ->label('Texto del Botón (CTA)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cta_link')
                    ->label('Enlace del Botón (CTA)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->label('Activo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtítulo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
        ];
    }
}
