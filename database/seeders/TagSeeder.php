<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Truncate the table safely (database-agnostic)
        Schema::disableForeignKeyConstraints();
        Tag::truncate();
        DB::table('post_tag')->truncate();
        Schema::enableForeignKeyConstraints();

        $this->command->info('Seeding tags...');

        // 2. Define Tags
        $tags = [
            'Laptops', 'Smartphones', 'Gaming', 'Consolas', 'PC Building', 'Accesorios',
            'Monitores', 'Teclados Mecánicos', 'Realidad Virtual', 'Drones', 'Audio Hi-Fi', 'Software',
            'Ofertas', 'Novedades', 'Guías de Compra'
        ];

        // 3. Create a progress bar
        $this->command->getOutput()->progressStart(count($tags));

        // 4. Create Tags
        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName)
            ]);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('\nTags table has been seeded with ' . count($tags) . ' professional tags!');
    }
}
