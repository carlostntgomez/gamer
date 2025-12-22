<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeminiApiKey;

class GeminiApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Iniciando el seeder de la clave API de Gemini...');

        // Clave API por defecto
        $defaultApiKey = 'AIzaSyBQ7CZFJC4rLG2qJulr1EAmwtpFXQ5dLjo';
        // Usamos updateOrCreate para actualizar el primer registro o crearlo si no existe.
        GeminiApiKey::updateOrCreate(
            ['id' => 1], // Buscamos por un campo específico para asegurar consistencia.
            ['api_key' => $defaultApiKey]
        );

        $this->command->info('El seeder de la clave API de Gemini ha finalizado con éxito.');
    }
}
