# Guía del Desarrollador para el Proyecto TecnnyGames

¡Hola! Este documento es tu manual personal para extender y hacer crecer el sitio web **TecnnyGames**. Sigue estos pasos para añadir nuevas páginas y funcionalidades de forma consistente con la arquitectura actual del proyecto.

---

## Parte 1: Cómo Crear una Nueva Página Estática

Utiliza este método para páginas con contenido que no cambia a menudo, como "Sobre Nosotros", "Políticas de Privacidad", "Términos y Condiciones", etc.

**Ejemplo: Crearemos una página de "Mapa del Sitio" (`/mapa-del-sitio`).**

### Paso 1: Definir la Ruta

Abre el archivo `routes/web.php` y añade una nueva ruta. Para páginas simples, puedes devolver la vista directamente sin necesidad de un controlador.

```php
// En routes/web.php

// ... (otras rutas)

// NUEVA RUTA PARA EL MAPA DEL SITIO
Route::get(\'/mapa-del-sitio\', function () {
    return view(\'pages.sitemap.index\');
})->name(\'sitemap.index\');
```

*   **`Route::get(...)`**: Define la URL que el usuario visitará.
*   **`view(...)`**: Laravel buscará el archivo `index.blade.php` dentro de la carpeta `resources/views/pages/sitemap/`.
*   **`name(...)`**: Asignar un nombre a la ruta es una buena práctica para poder enlazarla fácilmente desde otras partes del código.

### Paso 2: Crear la Vista Blade

1.  Ve al directorio `resources/views/pages/`.
2.  Crea una nueva carpeta. Para nuestro ejemplo, la llamaremos `sitemap`.
3.  Dentro de `resources/views/pages/sitemap/`, crea un nuevo archivo llamado `index.blade.php`.

**Pega este código base en tu nuevo archivo `index.blade.php`:**

```html
<x-layouts.app>
    <x-slot name="title">
        Mapa del Sitio | TecnnyGames
    </x-slot>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-title">Mapa del Sitio</h1>
                        <nav class="breadcrumb-nav">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                                <li class="breadcrumb-item active">Mapa del Sitio</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de la página -->
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2>Navegación Principal</h2>
                <ul>
                    <li><a href="{{ route(\'home\') }}">Inicio</a></li>
                    <li><a href="{{ route(\'shop.index\') }}">Tienda</a></li>
                    <li><a href="{{ route(\'posts.index\') }}">Blog</a></li>
                    <!-- Añade aquí más enlaces importantes -->
                </ul>

                <h2>Categorías de Productos</h2>
                {{-- Aquí podrías hacer una consulta para mostrar las categorías --}}

            </div>
        </div>
    </div>

</x-layouts.app>
```

### Paso 3: Añadir el Enlace al Menú (Opcional)

Si quieres que aparezca en el menú principal o en el pie de página, edita los componentes correspondientes:

*   **Cabecera:** `resources/views/components/layouts/header.blade.php`
*   **Pie de página:** `resources/views/components/layouts/footer.blade.php`

Busca una lista de enlaces `<li>` y añade el tuyo:

```html
<li><a href="{{ route(\'sitemap.index\') }}">Mapa del Sitio</a></li>
```

---

## Parte 2: Cómo Crear un Nuevo Recurso Completo

Este es el proceso para funcionalidades más complejas que requieren su propia tabla en la base de datos y su propio administrador en Filament.

**Ejemplo: Crearemos un recurso de "Sorteos" (`Giveaways`).**

### Paso 1: Base de Datos (Modelo y Migración)

1.  **Abre la terminal** en la raíz de tu proyecto.
2.  **Crea el Modelo y la Migración** con un solo comando:
    ```bash
    php artisan make:model Giveaway -m
    ```
    *   Esto crea el archivo del modelo en `app/Models/Giveaway.php`.
    *   Y el archivo de la migración en `database/migrations/`.

3.  **Edita el archivo de la migración** (ej: `database/migrations/YYYY_MM_DD_XXXXXX_create_giveaways_table.php`):

    ```php
    Schema::create(\'giveaways\', function (Blueprint $table) {
        $table->id();
        $table->string(\'title\');
        $table->string(\'slug\')->unique();
        $table->text(\'description\');
        $table->string(\'image_path\')->nullable();
        $table->timestamp(\'start_date\');
        $table->timestamp(\'end_date\');
        $table->boolean(\'is_active\')->default(true);
        $table->timestamps();
    });
    ```

4.  **Ejecuta la migración** para crear la tabla en la base de datos:
    ```bash
    php artisan migrate
    ```

5.  **Configura el Modelo** en `app/Models/Giveaway.php` para permitir la asignación masiva:

    ```php
    class Giveaway extends Model
    {
        use HasFactory;

        protected $fillable = [
            \'title\',
            \'slug\',
            \'description\',
            \'image_path\',
            \'start_date\',
            \'end_date\',
            \'is_active\',
        ];

        protected $casts = [
            \'start_date\' => \'datetime\',
            \'end_date\' => \'datetime\',
        ];
    }
    ```

### Paso 2: Panel de Administración (Filament)

1.  **Genera el Recurso de Filament** con este comando:
    ```bash
    php artisan make:filament-resource GiveawayResource --generate
    ```
    Esto creará todos los archivos necesarios en `app/Filament/Resources/GiveawayResource/`.

2.  **Configura el Formulario** en `app/Filament/Resources/GiveawayResource.php`:

    ```php
    // public static function form(Form $form): Form
    // dentro de la clase GiveawayResource

    return $form
        ->schema([
            Forms\Components\TextInput::make(\'title\')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set(\'slug\', Str::slug($state))),
            Forms\Components\TextInput::make(\'slug\')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\RichEditor::make(\'description\'),
            Forms\Components\FileUpload::make(\'image_path\')
                ->image()
                ->directory(\'giveaways\'),
            Forms\Components\DateTimePicker::make(\'start_date\')->required(),
            Forms\Components\DateTimePicker::make(\'end_date\')->required(),
            Forms\Components\Toggle::make(\'is_active\')->default(true),
        ]);
    ```

3.  **Configura la Tabla** en el mismo archivo `GiveawayResource.php`:

    ```php
    // public static function table(Table $table): Table
    // dentro de la clase GiveawayResource

    return $table
        ->columns([
            Tables\Columns\ImageColumn::make(\'image_path\')->label(\'Image\'),
            Tables\Columns\TextColumn::make(\'title\')->searchable(),
            Tables\Columns\IconColumn::make(\'is_active\')->boolean(),
            Tables\Columns\TextColumn::make(\'start_date\')->dateTime(),
            Tables\Columns\TextColumn::make(\'end_date\')->dateTime(),
        ])
        ->filters([
            // ...
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    ```

¡Ya puedes ir a tu panel de admin (`/admin`) y verás "Giveaways" en el menú lateral!

### Paso 3: El Frontend (Rutas, Controlador y Vistas)

1.  **Crea el Controlador**:
    ```bash
    php artisan make:controller GiveawayController
    ```

2.  **Define los Métodos en `app/Http/Controllers/GiveawayController.php`**:

    ```php
    use App\Models\Giveaway; // <-- Importa el modelo

    class GiveawayController extends Controller
    {
        public function index()
        {
            $giveaways = Giveaway::where(\'is_active\', true)
                                ->where(\'end_date\', \'>\', now())
                                ->latest()
                                ->paginate(10);

            return view(\'pages.giveaways.index\', compact(\'giveaways\'));
        }

        public function show(Giveaway $giveaway)
        {
            // Abortar si no está activo, a menos que sea un admin (lógica opcional)
            if (!$giveaway->is_active) {
                abort(404);
            }

            return view(\'pages.giveaways.show\', compact(\'giveaway\'));
        }
    }
    ```

3.  **Añade las Rutas en `routes/web.php`**:

    ```php
    use App\Http\Controllers\GiveawayController; // <-- Importa el controlador

    // ...

    Route::get(\'/sorteos\', [GiveawayController::class, \'index\'])->name(\'giveaways.index\');
    Route::get(\'/sorteos/{giveaway:slug}\', [GiveawayController::class, \'show\'])->name(\'giveaways.show\');
    ```

4.  **Crea las Vistas Blade**:
    *   Crea la carpeta `resources/views/pages/giveaways`.
    *   Crea el archivo `index.blade.php` para la lista de sorteos (puedes basarte en la vista `shop/index.blade.php` para la estructura del bucle y paginación).
    *   Crea el archivo `show.blade.php` para el detalle del sorteo (puedes basarte en la vista `shop/show.blade.php`).

---
¡Listo! Siguiendo estos patrones, podrás añadir cualquier funcionalidad que imagines a **TecnnyGames** manteniendo el código ordenado y profesional.
