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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Contenido y Configuración')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                Section::make('Información Principal')
                                    ->description('Define los detalles clave y la visibilidad del banner.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('name')
                                                ->label('Nombre del Banner')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Ej: Ofertas de Verano')
                                                ->helperText('Nombre interno para identificar el banner fácilmente.'),
                                            TextInput::make('url')
                                                ->label('URL de Destino')
                                                ->maxLength(255)
                                                ->placeholder('Ej: /productos/ofertas')
                                                ->helperText('Página a la que se redirige al hacer clic (opcional).'),
                                        ]),
                                        Grid::make(2)->schema([
                                            TextInput::make('order')
                                                ->label('Orden de Visualización')
                                                ->required()
                                                ->numeric()
                                                ->default(0)
                                                ->helperText('Un número más bajo (ej: 0) se mostrará primero.'),
                                            Toggle::make('is_active')
                                                ->label('Activo')
                                                ->required()
                                                ->default(true)
                                                ->helperText('Controla si el banner es visible en la web.'),
                                        ]),
                                    ]),

                                Section::make('Programación (Opcional)')
                                    ->description('Define un período para que el banner se muestre automáticamente.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            Forms\Components\DateTimePicker::make('starts_at')
                                                ->label('Fecha de Inicio')
                                                ->helperText('El banner será visible a partir de esta fecha y hora.'),
                                            Forms\Components\DateTimePicker::make('expires_at')
                                                ->label('Fecha de Expiración')
                                                ->helperText('El banner se ocultará después de esta fecha y hora.'),
                                        ]),
                                    ])
                            ]),

                        Tabs\Tab::make('Imagen del Banner')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Imagen')
                                    ->description('Sube la imagen principal para el banner.')
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('Imagen para el Banner')
                                            ->required()
                                            ->disk('public')
                                            ->directory('temp-uploads')
                                            ->image()
                                            ->imageEditor()
                                            ->rules(['dimensions:min_width=750,min_height=600'])
                                            ->validationMessages([
                                                'dimensions' => 'La imagen debe tener un tamaño mínimo de 750x600 píxeles.',
                                            ])
                                            ->imageEditorAspectRatios(['750:600'])
                                            ->imageEditorViewportWidth('750')
                                            ->imageEditorViewportHeight('600')
                                            ->helperText('Resolución obligatoria: 750x600px. La imagen se recortará a esta proporción.')
                                            ->imagePreviewHeight('300'),
                                    ])
                            ])
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->height(50),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Activo'),
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
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
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
            'index' => Pages\ListBanners::route('/'),
        ];
    }
}
