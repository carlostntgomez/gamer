<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Posts ---');

        // 1. Limpieza inicial
        $this->command->info('Limpiando registros y directorios de posts antiguos...');
        Post::query()->delete();
        Storage::disk('public')->deleteDirectory('posts');
        Storage::disk('public')->deleteDirectory('temp-uploads');
        Storage::disk('public')->makeDirectory('posts');
        Storage::disk('public')->makeDirectory('temp-uploads');
        $this->command->info('Limpieza completada.');

        // 2. Crear usuario administrador si no existe
        $this->command->info('Asegurando la existencia del usuario administrador...');
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@tecnnygames.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $this->command->info('Usuario administrador listo.');

        // 3. Obtener datos de relaciones
        $authors = Author::all();
        $tags = Tag::all();

        if ($authors->isEmpty()) {
            $this->command->error('No se encontraron autores. Ejecuta AuthorSeeder primero.');
            return;
        }

        if ($tags->isEmpty()) {
            $this->command->error('No se encontraron etiquetas. Ejecuta TagSeeder primero.');
            return;
        }

        // 4. Obtener imágenes de muestra
        $this->command->info('Buscando imágenes de muestra para los posts...');
        $sampleImagesPath = public_path('imagenes de muestra/posts');
        if (!File::exists($sampleImagesPath)) {
            $this->command->warn('El directorio de imágenes de muestra no existe en: ' . $sampleImagesPath);
            return;
        }
        $sampleImageFiles = File::files($sampleImagesPath);

        if (empty($sampleImageFiles)) {
            $this->command->warn('No se encontraron imágenes de muestra para los posts en public/imagenes de muestra/posts');
            return;
        }
        $this->command->info(count($sampleImageFiles) . ' imágenes de muestra encontradas.');

        // 5. Crear 10 posts
        $this->command->info('Creando 10 posts de prueba...');
        $progressBar = $this->command->getOutput()->createProgressBar(10);
        $progressBar->start();

        for ($i = 0; $i < 10; $i++) {
            // Simular subida de imagen
            $randomImage = $sampleImageFiles[array_rand($sampleImageFiles)];
            $tempFileName = 'temp-uploads/' . Str::random(40) . '.' . $randomImage->getExtension();
            File::copy($randomImage->getPathname(), Storage::disk('public')->path($tempFileName));

            $post = Post::factory()->create([
                'user_id' => $adminUser->id,
                'author_id' => $authors->random()->id,
                'main_image_path' => $tempFileName, // El observer se encargará de esto
            ]);

            // 6. Adjuntar etiquetas aleatorias
            $post->tags()->attach(
                $tags->random(rand(2, 5))->pluck('id')->toArray()
            );
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->info('\nCreación de posts finalizada.');


        $this->command->info('--- Seeder de Posts finalizado con éxito ---');
    }
}
