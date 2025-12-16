<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('pages')->truncate();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        Page::create([
            'title' => 'Acerca de Nosotros',
            'slug' => 'about-us',
            'content' => [
                'about_banner_image' => null, // Will be handled by Filament upload
                'mission_title' => 'Nuestra Misión',
                'mission_paragraph' => 'Nuestra misión es proporcionar los mejores gadgets y videojuegos, garantizando calidad y satisfacción al cliente. Nos esforzamos por ofrecer productos innovadores y un servicio excepcional.',
                'vision_title' => 'Nuestra Visión',
                'vision_paragraph' => 'Ser la tienda líder en tecnología y entretenimiento digital, expandiendo nuestro alcance y manteniendo un compromiso firme con la excelencia y la comunidad gamer.',
                'project_counts' => [
                    ['count_number' => '10', 'count_label' => 'Años', 'count_image' => 'https://spacingtech.com/html/electon/electon/img/about/years.png'],
                    ['count_number' => '10', 'count_label' => 'M+ Clientes', 'count_image' => 'https://spacingtech.com/html/electon/electon/img/about/clients.png'],
                    ['count_number' => '50', 'count_label' => 'Tiendas', 'count_image' => 'https://spacingtech.com/html/electon/electon/img/about/shops.png'],
                    ['count_number' => '17', 'count_label' => 'M+ Ventas', 'count_image' => 'https://spacingtech.com/html/electon/electon/img/about/sales.png'],
                ],
                'team_members' => [
                    ['member_name' => 'Johnny Walker', 'member_designation' => 'Diseñador Web', 'member_description' => 'Vestibulum porttitor egestas orci, vitae ullamcorper risus rutrum massa quis.', 'member_image' => 'img/team/team-1.jpg'],
                    ['member_name' => 'Rebecca Flex', 'member_designation' => 'Soporte', 'member_description' => 'Vestibulum porttitor egestas orci, vitae ullamcorper risus rutrum massa quis.', 'member_image' => 'img/team/team-2.jpg'],
                    ['member_name' => 'Jan Ringo', 'member_designation' => 'Subdirector de Ventas', 'member_description' => 'Vestibulum porttitor egestas orci, vitae ullamcorper risus rutrum massa quis.', 'member_image' => 'img/team/team-3.jpg'],
                    ['member_name' => 'Ringo Kai', 'member_designation' => 'Miembro de Política', 'member_description' => 'Vestibulum porttitor egestas orci, vitae ullamcorper risus rutrum massa quis.', 'member_image' => 'img/team/team-4.jpg'],
                ],
            ],
            'seo_title' => 'Acerca de TecnnyGames',
            'seo_description' => 'Conoce nuestra historia, misión, visión y el equipo detrás de TecnnyGames.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Contáctanos',
            'slug' => 'contact-us',
            'content' => ['main_content' => '¿Tienes alguna pregunta o necesitas ayuda? Contáctanos a través de nuestro formulario o por correo electrónico.'],
            'seo_title' => 'Contáctanos - TecnnyGames',
            'seo_description' => 'Formulario de contacto y datos de soporte de TecnnyGames.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Preguntas Frecuentes',
            'slug' => 'faq',
            'content' => ['main_content' => 'Encuentra respuestas a las preguntas más comunes sobre nuestros productos, pedidos y servicios.'],
            'seo_title' => 'Preguntas Frecuentes - TecnnyGames',
            'seo_description' => 'Resuelve tus dudas en nuestra sección de preguntas frecuentes.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Política de Pago',
            'slug' => 'payment-policy',
            'content' => ['main_content' => 'Información detallada sobre nuestros métodos de pago, seguridad y términos de transacción.'],
            'seo_title' => 'Política de Pago - TecnnyGames',
            'seo_description' => 'Conoce nuestras políticas y métodos de pago seguros.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Política de Privacidad',
            'slug' => 'privacy-policy',
            'content' => ['main_content' => 'Descubre cómo TecnnyGames protege tu información personal y tus datos.'],
            'seo_title' => 'Política de Privacidad - TecnnyGames',
            'seo_description' => 'Tu privacidad es importante. Lee nuestra política completa aquí.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Política de Devolución',
            'slug' => 'return-policy',
            'content' => ['main_content' => 'Entiende nuestras políticas para devoluciones y cambios de productos.'],
            'seo_title' => 'Política de Devolución - TecnnyGames',
            'seo_description' => 'Información sobre cómo devolver o cambiar un artículo en TecnnyGames.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Política de Envío',
            'slug' => 'shipping-policy',
            'content' => ['main_content' => 'Detalles sobre opciones de envío, tiempos de entrega y costes.'],
            'seo_title' => 'Política de Envío - TecnnyGames',
            'seo_description' => 'Todo lo que necesitas saber sobre el envío de tus pedidos.',
            'is_published' => true,
        ]);

        Page::create([
            'title' => 'Términos y Condiciones',
            'slug' => 'terms-condition',
            'content' => ['main_content' => 'Lee los términos y condiciones que rigen el uso de nuestro sitio web y servicios.'],
            'seo_title' => 'Términos y Condiciones - TecnnyGames',
            'seo_description' => 'Términos legales que aplican al comprar en TecnnyGames.',
            'is_published' => true,
        ]);
    }
}
