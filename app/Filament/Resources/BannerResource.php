<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Home';

    // Traducciones
    protected static ?string $modelLabel = 'Banner';
    protected static ?string $pluralModelLabel = 'Banners';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Banner')
                    ->description('Define los detalles principales y la visibilidad del banner.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Ej: Banner de Rebajas de Verano'),
                            TextInput::make('url')
                                ->label('URL de destino')
                                ->maxLength(255)
                                ->placeholder('Ej: /ofertas/verano'),
                        ]),
                        Grid::make(2)->schema([
                             TextInput::make('order')
                                ->label('Orden')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->helperText('Un número más bajo se muestra primero.'),
                            Toggle::make('is_active')
                                ->label('¿Está activo?')
                                ->required()
                                ->default(true),
                        ]),
                    ]),

                Section::make('Programación (Opcional)')
                    ->description('Establece un período de tiempo para que el banner se muestre automáticamente.')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\DateTimePicker::make('starts_at')
                                ->label('Fecha de inicio'),
                            Forms\Components\DateTimePicker::make('expires_at')
                                ->label('Fecha de expiración'),
                        ]),
                    ]),

                Section::make('Imagen del Banner')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Imagen')
                            ->required()
                            ->directory('banners') // Directorio en public
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->getUploadedFileNameForStorageUsing(function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file): string {
                                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                                return (string) str($fileName)->append('-' . uniqid() . '.webp');
                            })
                            ->helperText('La imagen se convertirá a formato WebP para optimizar la carga.'),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->width(150)
                    ->height('auto'),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                TextColumn::make('starts_at')
                    ->label('Inicia')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->label('Expira')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modal(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
        ];
    }
}
