<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Información General y Legal
            ['key' => 'copyright_text', 'value' => 'Copyright ' . date('Y') . ' TecnnyGames. Todos los derechos reservados.'],
            ['key' => 'company_name', 'value' => 'TecnnyGames'],
            ['key' => 'legal_country', 'value' => 'Colombia'],
            ['key' => 'legal_jurisdiction_city', 'value' => 'Medellín, Colombia'],

            // Información de Contacto
            ['key' => 'phone', 'value' => '+57 604 1234567'],
            ['key' => 'email', 'value' => 'soporte@tecnnygames.com'],
            ['key' => 'address', 'value' => "Calle 10 #43A-30\nEl Poblado\nMedellín, Antioquia, Colombia"],

            // Redes Sociales (URLs de ejemplo)
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/tecnnygames'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/tecnnygames'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/tecnnygames'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/tecnnygames'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/c/tecnnygames'],

            // Contenido de Políticas (Texto de ejemplo)
            [
                'key' => 'terms_conditions_content',
                'value' => "Bienvenido a TecnnyGames. Estos términos y condiciones describen las reglas y regulaciones para el uso del sitio web de TecnnyGames, ubicado en Medellín, Colombia. Al acceder a este sitio web, asumimos que aceptas estos términos y condiciones. No continúes usando TecnnyGames si no estás de acuerdo con todos los términos y condiciones establecidos en esta página.\n\nLa ley de Colombia regirá cualquier disputa relacionada con estos términos."
            ],
            [
                'key' => 'privacy_policy_content',
                'value' => "En TecnnyGames, accesible desde nuestro sitio web, una de nuestras principales prioridades es la privacidad de nuestros visitantes. Este documento de Política de Privacidad contiene tipos de información que son recopilados y registrados por TecnnyGames y cómo la usamos.\n\nSi tienes preguntas adicionales o requieres más información sobre nuestra Política de Privacidad, no dudes en contactarnos a través del correo electrónico soporte@tecnnygames.com."
            ],
            [
                'key' => 'return_policy_content',
                'value' => "Nuestra política de devoluciones en TecnnyGames te permite devolver productos dentro de los 7 días posteriores a la recepción. Para ser elegible para una devolución, tu artículo debe estar sin usar y en las mismas condiciones en que lo recibiste. También debe estar en el embalaje original.\n\nPara iniciar una devolución, por favor contáctanos en soporte@tecnnygames.com con tu número de pedido y el motivo de la devolución."
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
