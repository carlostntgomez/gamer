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

    protected static ?string $modelLabel = 'Banner';
    protected static ?string $pluralModelLabel = 'Banners';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información Principal del Banner')
                    ->description('Define los detalles clave y la visibilidad del banner en el sitio.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Ej: Banner de Rebajas de Verano')
                                ->helperText('Nombre interno para identificar el banner.'),
                            TextInput::make('url')
                                ->label('URL de destino')
                                ->maxLength(255)
                                ->placeholder('Ej: /ofertas/verano')
                                ->helperText('La página a la que se redirige al hacer clic. Opcional.'),
                        ]),
                        Grid::make(2)->schema([
                             TextInput::make('order')
                                ->label('Orden de Visualización')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->helperText('Un número más bajo (ej: 0 o 1) se mostrará primero.'),
                            Toggle::make('is_active')
                                ->label('Activo')
                                ->required()
                                ->default(true)
                                ->helperText('Solo los banners activos se mostrarán en la web.'),
                        ]),
                    ]),

                Section::make('Programación y Duración (Opcional)')
                    ->description('Establece un período de tiempo para que el banner se muestre y oculte automáticamente.')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\DateTimePicker::make('starts_at')
                                ->label('Fecha de Inicio')
                                ->helperText('El banner será visible a partir de esta fecha.'),
                            Forms\Components\DateTimePicker::make('expires_at')
                                ->label('Fecha de Expiración')
                                ->helperText('El banner se ocultará después de esta fecha.'),
                        ]),
                    ]),

                Section::make('Imagen del Banner')
                    ->description('Sube la imagen que se mostrará. Se recomienda un formato optimizado para la web.')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Imagen')
                            ->required()
                            ->directory('banners')
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->getUploadedFileNameForStorageUsing(function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file): string {
                                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                                return (string) str($fileName)->append('-' . uniqid() . '.webp');
                            })
                            ->helperText('La imagen se convertirá a formato WebP para optimizar la velocidad de carga. Dimensiones recomendadas: 1920x500px.'),
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
                    ->height('auto')
                    ->square(),
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('expires_at')
                    ->label('Expira')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->boolean()
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
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
