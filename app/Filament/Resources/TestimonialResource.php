<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Tabs;

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
                Tabs::make('TestimonialTabs')->tabs([
                    Tabs\Tab::make('Contenido del Testimonio')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->schema([
                            Forms\Components\TextInput::make('author_name')
                                ->label('Nombre del Autor')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('author_title')
                                ->label('Cargo/Título del Autor')
                                ->maxLength(255)
                                ->helperText('Ej: Cliente Satisfecho, CEO de Empresa, etc. Opcional.')
                                ->nullable(),
                            RichEditor::make('content')
                                ->label('Contenido del Testimonio')
                                ->required()
                                ->maxLength(65535)
                                ->columnSpanFull(),
                        ])->columns(2),

                    Tabs\Tab::make('Detalles y Visibilidad')
                        ->icon('heroicon-o-eye')
                        ->schema([
                            FileUpload::make('image_path')
                                ->label('Foto del Autor')
                                ->directory('testimonials')->disk('public')->image()->imageEditor()
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->beforeLast('.')
                                        ->slug()
                                        ->append('-' . uniqid() . '.webp')
                                )
                                ->helperText('Opcional. La foto se mostrará junto al testimonio.')
                                ->columnSpanFull(),
                            Select::make('rating')
                                ->label('Calificación')
                                ->options([ 1 => '1 Estrella', 2 => '2 Estrellas', 3 => '3 Estrellas', 4 => '4 Estrellas', 5 => '5 Estrellas' ])
                                ->numeric()
                                ->nullable(),
                            Toggle::make('is_published')
                                ->label('Publicado')
                                ->default(false)
                                ->helperText('Controla si el testimonio es visible públicamente en el sitio.'),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('Foto')->disk('public')->circular()->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('author_name')->label('Autor')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('rating')->label('Calificación')->numeric()->sortable()->formatStateUsing(fn (?int $state): string => $state ? str_repeat('⭐', $state) : 'N/A'),
                IconColumn::make('is_published')->label('Publicado')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')->label('Calificación')->options([ 1 => '1 Estrella', 2 => '2 Estrellas', 3 => '3 Estrellas', 4 => '4 Estrellas', 5 => '5 Estrellas' ]),
                Tables\Filters\TernaryFilter::make('is_published')->label('Estado')->trueLabel('Publicado')->falseLabel('Borrador'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTestimonials::route('/'),
        ];
    }
}
