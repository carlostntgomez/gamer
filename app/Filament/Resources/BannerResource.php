<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Tabs;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $modelLabel = 'Banner';
    protected static ?string $pluralModelLabel = 'Banners';
    protected static ?string $navigationLabel = 'Banners';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('BannerTabs')->tabs([
                    Tabs\Tab::make('Contenido del Banner')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre del Banner')
                                ->required()
                                ->maxLength(255)
                                ->helperText('Nombre interno para identificar el banner.'),
                            Forms\Components\TextInput::make('url')
                                ->label('URL (Enlace del Banner)')
                                ->url()
                                ->maxLength(255)
                                ->nullable()
                                ->helperText('La dirección a la que se redirigirá al hacer clic en el banner. Opcional.'),
                            FileUpload::make('image_path')
                                ->label('Imagen del Banner')
                                ->directory('banners')->disk('public')->image()->imageEditor()
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->beforeLast('.')
                                        ->slug()
                                        ->append('-' . uniqid() . '.webp')
                                )
                                ->columnSpanFull(),
                        ])->columns(2),

                    Tabs\Tab::make('Reglas de Visualización')
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Activo')
                                ->default(true)
                                ->helperText('Controla si el banner está visible en el sitio web.'),
                            Forms\Components\TextInput::make('order')
                                ->label('Orden de Visualización')
                                ->numeric()
                                ->default(0)
                                ->helperText('Un número para ordenar los banners. Menor número se muestra primero.'),
                            Forms\Components\DateTimePicker::make('starts_at')
                                ->label('Fecha de Inicio')
                                ->native(false)
                                ->nullable()
                                ->helperText('El banner aparecerá a partir de esta fecha.'),
                            Forms\Components\DateTimePicker::make('expires_at')
                                ->label('Fecha de Caducidad')
                                ->native(false)
                                ->nullable()
                                ->helperText('El banner dejará de ser visible después de esta fecha.'),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('Imagen')->disk('public')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('is_active')->label('Estado')->badge()->formatStateUsing(fn (bool $state): string => $state ? 'Activo' : 'Inactivo')->color(fn (bool $state): string => $state ? 'success' : 'danger')->sortable(),
                Tables\Columns\TextColumn::make('order')->label('Orden')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('starts_at')->label('Inicia')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('expires_at')->label('Expira')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Estado')->trueLabel('Activo')->falseLabel('Inactivo'),
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
            ->defaultSort('order', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
        ];
    }
}
