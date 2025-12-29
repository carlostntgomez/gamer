<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    private array $sampleImages = [];
    private string $storagePath = 'public/posts';
    private $tags;
    private $users;

    public function run(): void
    {
        $this->command->info('🚀 Iniciando el seeder de Posts, estilo ProductSeeder...');

        if (!$this->prepareEnvironment()) return;

        $titles = $this->getPostTitles();
        $this->command->info('Creando ' . count($titles) . ' posts de alta calidad...');
        $progressBar = $this->command->getOutput()->createProgressBar(count($titles));

        foreach ($titles as $title) {
            $postData = $this->generatePostData($title);
            
            $post = Post::create($postData);

            $this->attachTagsToPost($post);
            $this->attachImageToPost($post);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->info('\n✅ Seeder de Posts finalizado con éxito.');
    }

    private function prepareEnvironment(): bool
    {
        $this->command->info('🧹 Limpiando el entorno de Posts...');
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        DB::table('post_tag')->truncate();
        Schema::enableForeignKeyConstraints();

        Storage::deleteDirectory($this->storagePath);
        Storage::makeDirectory($this->storagePath);

        $sampleImagesPath = public_path('imagenes de muestra/posts');
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error("La carpeta de imágenes de muestra para posts está vacía o no existe: {$sampleImagesPath}");
            return false;
        }
        $this->sampleImages = File::files($sampleImagesPath);

        $this->tags = Tag::all();
        $this->users = User::all();

        if ($this->tags->isEmpty()) {
            $this->command->error('No se encontraron tags. Ejecute el TagSeeder primero.');
            return false;
        }
        if ($this->users->isEmpty()) {
            $this->command->error('No se encontraron usuarios. Asegúrese de que el seeder de usuarios se ejecute primero.');
            return false;
        }
        
        $this->command->info('Entorno preparado: ' . $this->users->count() . ' usuarios, ' . $this->tags->count() . ' tags, y ' . count($this->sampleImages) . ' imágenes de muestra encontradas.');
        return true;
    }

    private function generatePostData(string $title): array
    {
        $htmlContent = $this->generateHtmlContent($title);
        return [
            'user_id' => $this->users->random()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $htmlContent,
            'excerpt' => Str::limit(strip_tags($htmlContent), 150),
            'is_published' => true,
            'published_at' => now()->subDays(rand(1, 365)),
            'seo_title' => 'Guía y Análisis: ' . $title,
            'seo_description' => 'Todo lo que necesitas saber sobre ' . $title . '. Análisis, comparativas y las mejores ofertas.',
        ];
    }
    
    private function attachTagsToPost(Post $post): void
    {
        $post->tags()->attach(
            $this->tags->random(rand(2, 5))->pluck('id')->toArray()
        );
    }
    
    private function attachImageToPost(Post $post): void
    {
        if (empty($this->sampleImages)) return;

        $imageFile = fake()->randomElement($this->sampleImages);
        $imageDbPath = $this->processAndSaveImage($imageFile, $post->slug);

        if($imageDbPath) {
            $post->image_path = $imageDbPath;
            $post->save();
        }
    }

    private function processAndSaveImage(\SplFileInfo $imageFile, string $slug): ?string
    {
        $sourcePath = $imageFile->getRealPath();
        $newFileName = $slug . '-' . uniqid() . '.webp';
        $destinationPath = Storage::disk('public')->path('posts/' . $newFileName);

        try {
            $image = imagecreatefromstring(File::get($sourcePath));
            if ($image === false) return null;

            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagewebp($image, $destinationPath, 80);
            imagedestroy($image);
            
            return 'posts/' . $newFileName;

        } catch (\Exception $e) {
            $this->command->warn("No se pudo procesar la imagen del post: {$sourcePath}. Error: " . $e->getMessage());
            return null;
        }
    }

    private function generateHtmlContent(string $title): string
    {
        $faker = \Faker\Factory::create('es_ES');
        $content = "<h2>Análisis Profundo: {$title}</h2>";
        $content .= "<p>{$faker->paragraph(5, true)}</p>";
        $content .= "<h3>Características Clave</h3><ul>";
        for ($i = 0; $i < 3; $i++) {
            $content .= "<li><strong>" . ucfirst($faker->words(3, true)) . ":</strong> " . $faker->sentence(12, true) . "</li>";
        }
        $content .= "</ul><p>{$faker->paragraph(6, true)}</p>";
        $content .= "<h3>Veredicto Final y Recomendaciones</h3><p>{$faker->paragraph(4, true)}</p>";

        return $content;
    }
    
    private function getPostTitles(): array
    {
        return [
            'Guía Definitiva para Elegir el Mejor Portátil Gaming en 2024',
            'Análisis a Fondo del Nuevo Smartphone Insignia: ¿Vale la Pena?',
            'Cómo Montar tu Propio PC Gamer Paso a Paso: Presupuestos y Consejos',
            'Los 10 Accesorios Imprescindibles que Todo Gamer Debería Tener',
            'Comparativa de Monitores: ¿4K, 144Hz o Ultrawide para Jugar y Trabajar?',
            'El Auge de los Teclados Mecánicos: Todo lo que Necesitas Saber',
            'Realidad Virtual en 2024: Los Dispositivos que Están Definiendo el Futuro',
            'Los Mejores Drones para Principiantes: Captura Vistas Aéreas Impresionantes',
            'Audio de Alta Fidelidad para tu Setup: Auriculares y Altavoces Recomendados',
            'Las Aplicaciones de Software Esenciales para Optimizar tu Rendimiento',
            'PlayStation 5 vs. Xbox Series X: La Batalla de las Consolas de Nueva Generación',
            'Secretos para Encontrar las Mejores Ofertas en Componentes de PC',
            '¿Es el Fin de las Tarjetas Gráficas Dedicadas? El Futuro de la GPU Integrada',
            'La Guía Completa para Hacer Overclocking a tu CPU de Forma Segura',
            'Novedades Tecnológicas que Marcarán la Próxima Década',
        ];
    }
}
