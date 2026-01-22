<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainSliderResource\Pages;
use App\Models\MainSlider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Str;

class MainSliderResource extends Resource
{
    protected static ?string $model = MainSlider::class;

    protected static ?string $modelLabel = 'Slider Principal';
    protected static ?string $pluralModelLabel = 'Sliders Principales';
    protected static ?string $navigationLabel = 'Sliders Principales';
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Home';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Contenido y Ajustes')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                Section::make('Contenido del Slider')
                                    ->schema([
                                        Forms\Components\RichEditor::make('subtitle')
                                            ->label('Título')
                                            ->required()
                                            ->maxLength(65535)
                                            ->helperText('Recomendación: Usa un título corto y utiliza el formato H2 para una mejor visualización.'),

                                        Forms\Components\TextInput::make('title')
                                            ->label('Subtítulo')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('El texto secundario que complementa al título principal.'),
                                    ])->columns(1),

                                Section::make('Botón de Acción')
                                    ->schema([
                                        Forms\Components\TextInput::make('button_text')
                                            ->label('Texto del Botón')
                                            ->maxLength(255)
                                            ->helperText('El texto que aparecerá en el botón (ej. \'Ver más\').'),

                                        Forms\Components\TextInput::make('button_link')
                                            ->label('Enlace del Botón')
                                            ->maxLength(255)
                                            ->helperText('La URL a la que redirigirá el botón (ej. \'/productos\').'),
                                    ])->columns(2),

                                Section::make('Estado')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Visible')
                                            ->default(true)
                                            ->helperText('Controla si el slider se muestra en la página principal.'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Imágenes')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('Imagen de Escritorio')
                                    ->required()
                                    ->image()
                                    ->rules(['dimensions:min_width=1920,min_height=930'])
                                    ->validationMessages([
                                        'dimensions' => 'La imagen debe tener un tamaño mínimo de 1920x930 píxeles.',
                                    ])
                                    ->helperText('Resolución obligatoria: 1920x930px.')
                                    ->imageEditor()
                                    ->imageEditorAspectRatios(['1920:930'])
                                    ->imageEditorViewportWidth('1920')
                                    ->imageEditorViewportHeight('930')
                                    ->directory('temp-uploads')
                                    ->disk('public'),

                                Forms\Components\FileUpload::make('image_path_mobile')
                                    ->label('Imagen para Móvil')
                                    ->image()
                                    ->rules(['dimensions:min_width=600,min_height=470'])
                                    ->validationMessages([
                                        'dimensions' => 'La imagen debe tener un tamaño mínimo de 600x470 píxeles.',
                                    ])
                                    ->helperText('Resolución obligatoria: 600x470px.')
                                    ->imageEditor()
                                    ->imageEditorAspectRatios(['600:470'])
                                    ->imageEditorViewportWidth('600')
                                    ->imageEditorViewportHeight('470')
                                    ->directory('temp-uploads')
                                    ->disk('public'),
                            ])->columns(2),
                    ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Título')
                    ->html()
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Subtítulo')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Imagen de Escritorio')
                    ->height(80),
                Tables\Columns\ImageColumn::make('image_path_mobile')
                    ->label('Imagen Móvil')
                    ->height(80),
                Tables\Columns\ToggleColumn::make('is_visible')
                    ->label('Visible'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListMainSliders::route('/'),
        ];
    }
}
