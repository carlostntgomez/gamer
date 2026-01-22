<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Autores ---');

        $this->command->info('Limpiando la tabla de autores...');
        Author::query()->delete();

        $totalAuthors = 3;
        $this->command->info("Creando {$totalAuthors} autores de prueba...");
        
        Author::factory($totalAuthors)->create();
        
        $this->command->info("Se han creado {$totalAuthors} autores con éxito.");
        $this->command->info('--- Seeder de Autores finalizado ---');
    }
}