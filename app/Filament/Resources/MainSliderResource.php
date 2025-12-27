<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainSliderResource\Pages;
use App\Models\MainSlider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;

class MainSliderResource extends Resource
{
    protected static ?string $model = MainSlider::class;

    protected static ?string $modelLabel = 'Slider Principal';
    protected static ?string $pluralModelLabel = 'Sliders Principales';
    protected static ?string $navigationLabel = 'Sliders Principales';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Home';

    public static function form(Form $form): Form
    {
        $saveImageLogic = function ($state): ?string {
            if (!$state instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                return $state; // Keep existing path if not changed
            }

            $storagePath = storage_path('app/public/main-slider');
            if (!File::isDirectory($storagePath)) {
                File::makeDirectory($storagePath, 0755, true, true);
            }

            $originalName = $state->getClientOriginalName();
            $newFileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '-' . uniqid() . '.webp';
            $destinationPath = $storagePath . '/' . $newFileName;

            try {
                $sourcePath = $state->getRealPath();
                $image = imagecreatefromstring(File::get($sourcePath));

                if ($image === false) return null;

                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                imagewebp($image, $destinationPath, 80); // 80 is quality
                imagedestroy($image);

                return 'main-slider/' . $newFileName;

            } catch (\Exception $e) {
                // Optionally log the error
                return null;
            }
        };

        return $form
            ->schema([
                Section::make('Contenido de Texto')->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('subtitle')
                        ->label('Subtítulo')
                        ->required()
                        ->maxLength(255),
                ])->columns(1),

                Section::make('Imágenes')->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Imagen de Escritorio')
                        ->required()
                        ->image()
                        ->helperText('La imagen debe tener un tamaño mínimo de 1920x930 píxeles. Se convertirá a WebP.')
                        ->imageEditor()
                        ->imageEditorAspectRatios(['64:31'])
                        ->rules(['dimensions:min_width=1920,min_height=930'])
                        ->dehydrateStateUsing($saveImageLogic),
                    Forms\Components\FileUpload::make('image_path_mobile')
                        ->label('Imagen Móvil')
                        ->image()
                        ->helperText('La imagen debe tener un tamaño mínimo de 360x430 píxeles. Se convertirá a WebP.')
                        ->imageEditor()
                        ->imageEditorAspectRatios(['36:43'])
                        ->rules(['dimensions:min_width=360,min_height=430'])
                        ->dehydrateStateUsing($saveImageLogic),
                ])->columns(2),

                Section::make('Botón de Acción')->schema([
                    Forms\Components\TextInput::make('button_text')
                        ->label('Texto del Botón')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('button_link')
                        ->label('Enlace del Botón')
                        ->maxLength(255),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtítulo')
                    ->html(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Imagen de Escritorio'),
                Tables\Columns\ImageColumn::make('image_path_mobile')
                    ->label('Imagen Móvil'),
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
