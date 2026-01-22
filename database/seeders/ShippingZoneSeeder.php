<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingZone;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vaciar la tabla para asegurar un set de datos limpio y completo.
        ShippingZone::truncate();

        $zones = [
            'Medellín' => [
                // Comuna 1 - Popular
                'Popular No.1' => 8500, 'Popular No.2' => 8500, 'Santo Domingo Savio No.1' => 9000, 'Santo Domingo Savio No.2' => 9000, 'Granizal' => 9500, 'Moscú No.2' => 9000, 'Villa Guadalupe' => 8500, 'San Pablo' => 8500, 'Aldea Pablo VI' => 9000, 'La Esperanza No.2' => 9000, 'El Compromiso' => 9500, 'La Avanzada' => 9500, 'Carpinelo' => 10000,
                // Comuna 2 - Santa Cruz
                'Santa Cruz' => 8500, 'La Isla' => 9000, 'El Playón de los Comuneros' => 8500, 'Pablo VI' => 8500, 'La Frontera' => 8500, 'La Francia' => 8500, 'Andalucía' => 8000, 'Villa del Socorro' => 8500, 'Villa Niza' => 8500, 'Moscú No.1' => 8500, 'La Rosa' => 8000,
                // Comuna 3 - Manrique
                'La Salle' => 7500, 'Las Granjas' => 8000, 'Campo Valdés No.2' => 7500, 'Santa Inés' => 8000, 'El Raizal' => 8000, 'El Pomar' => 8500, 'Manrique Central No.2' => 7500, 'Manrique Oriental' => 8000, 'Versalles No.1' => 8000, 'Versalles No.2' => 8000, 'La Cruz' => 8500, 'La Honda' => 9000, 'Oriente' => 7500, 'María Cano Carambolas' => 8000, 'San José La Cima No.1' => 9000, 'San José La Cima No.2' => 9000,
                // Comuna 4 - Aranjuez
                'Aranjuez' => 7000, 'Berlín' => 7500, 'San Isidro' => 7000, 'Palermo' => 7000, 'Bermejal Los Álamos' => 7500, 'Moravia' => 8000, 'Sevilla' => 7000, 'San Pedro' => 7000, 'Manrique Central No.1' => 7000, 'Campo Valdés No.1' => 7000, 'Las Esmeraldas' => 7500, 'La Piñuela' => 7500, 'Brasilia' => 7500, 'Miranda' => 7000,
                // Comuna 5 - Castilla
                'Castilla' => 6500, 'Toscana' => 7000, 'La Paralela' => 6500, 'Las Brisas' => 7000, 'Florencia' => 7000, 'Tejelo' => 6500, 'Boyacá' => 6500, 'Héctor Abad Gómez' => 6500, 'Belalcázar' => 6500, 'Girardot' => 6000, 'Tricentenario' => 6000, 'Francisco Antonio Zea' => 6500, 'Alfonso López' => 6500, 'Caribe' => 6000, 'El Progreso' => 7000,
                // Comuna 6 - Doce de Octubre
                'Doce de Octubre No.1' => 7000, 'Doce de Octubre No.2' => 7000, 'Santander' => 7500, 'Pedregal' => 7500, 'La Esperanza' => 7500, 'San Martín de Porres' => 7000, 'Kennedy' => 7500, 'Picacho' => 8000, 'Picachito' => 8000, 'Mirador del Doce' => 8000, 'El Progreso No.2' => 7500, 'El Triunfo' => 7500,
                // Comuna 7 - Robledo
                'Robledo' => 6000, 'Cerro El Volador' => 5500, 'San Germán' => 5500, 'Facultad de Minas' => 5500, 'La Pilarica' => 6000, 'Bosques de San Pablo' => 6500, 'Altamira' => 7000, 'Córdoba' => 6000, 'López de Mesa' => 6000, 'El Diamante' => 6500, 'Aures No.1' => 7000, 'Aures No.2' => 7000, 'Bello Horizonte' => 6500, 'Villa Flora' => 6500, 'Palenque' => 7000, 'Cucaracho' => 7500, 'Fuente Clara' => 7500, 'Santa Margarita' => 7500, 'Olaya Herrera' => 6000, 'Pajarito' => 8500, 'Monteclaro' => 8000, 'Villa de La Iguaná' => 6500, 'La Cuchilla' => 7000, 'La Aurora' => 8500,
                // Comuna 8 - Villa Hermosa
                'Villa Hermosa' => 7500, 'La Mansión' => 7500, 'San Miguel' => 7500, 'La Ladera' => 7500, 'Golondrinas' => 8000, 'Batallón Girardot' => 7000, 'Llanaditas' => 8500, 'Los Mangos' => 8000, 'Enciso' => 8000, 'Sucre' => 7500, 'El Pinal' => 8000, 'Trece de Noviembre' => 8500, 'La Libertad' => 8500, 'Villatina' => 8500, 'San Antonio' => 8500, 'Las Estancias' => 8000, 'Villa Turbay' => 9000, 'La Sierra' => 9500, 'Villa Lilliam' => 9000, 'Esfuerzos de Paz No.1' => 9000, 'Esfuerzos de Paz No.2' => 9000,
                // Comuna 9 - Buenos Aires
                'Buenos Aires' => 7000, 'Caicedo' => 7500, 'Juan Pablo II' => 7500, 'Ocho de Marzo' => 7500, 'Barrios de Jesús' => 7500, 'Bomboná No.2' => 7000, 'Los Cerros El Vergel' => 7500, 'Alejandro Echavarría' => 7000, 'Miraflores' => 7000, 'Cataluña' => 7000, 'La Milagrosa' => 7500, 'Gerona' => 7000, 'El Salvador' => 7000, 'Loreto' => 7000, 'Asomadera No.1' => 6500, 'Asomadera No.2' => 6500, 'Asomadera No.3' => 6500, 'Quinta Linda' => 7000, 'Barrio Pablo Escobar' => 8000,
                // Comuna 10 - La Candelaria
                'La Candelaria' => 6000, 'Prado' => 6500, 'Jesús Nazareno' => 6000, 'El Chagualo' => 6500, 'Estación Villa' => 6500, 'San Benito' => 6500, 'Guayaquil' => 6000, 'Corazón de Jesús Barrio Triste' => 6000, 'Calle Nueva' => 6000, 'Perpetuo Socorro' => 5500, 'Barrio Colón' => 5500, 'Las Palmas' => 6500, 'Bomboná No.1' => 6000, 'Boston' => 6000, 'Los Ángeles' => 6000, 'Villa Nueva' => 6000, 'San Diego' => 5500,
                // Comuna 11 - Laureles-Estadio
                'Carlos E Restrepo' => 4500, 'Suramericana' => 4500, 'Naranjal' => 5000, 'San Joaquín' => 4000, 'Los Conquistadores' => 4000, 'Bolivariana' => 4000, 'Laureles' => 4000, 'Las Acacias' => 4000, 'La Castellana' => 4000, 'Lorena' => 4000, 'El Velódromo' => 4500, 'Estadio' => 4500, 'Los Colores' => 5000, 'Cuarta Brigada' => 5000, 'Florida Nueva' => 4500,
                // Comuna 12 - La América
                'La América' => 5000, 'Calasanz' => 5500, 'Los Pinos' => 5000, 'La Floresta' => 5000, 'Santa Lucía' => 5000, 'El Danubio' => 5000, 'Campo Alegre' => 5500, 'Santa Mónica' => 5500, 'Barrio Cristóbal' => 5000, 'Simón Bolívar' => 5000, 'Santa Teresita' => 5500, 'Calasanz Parte Alta' => 6000,
                // Comuna 13 - San Javier
                'San Javier No.1' => 7000, 'San Javier No.2' => 7000, 'El Pesebre' => 7500, 'Blanquizal' => 7000, 'Santa Rosa de Lima' => 7000, 'Los Alcázares' => 7000, 'Metropolitano' => 7500, 'La Pradera' => 7500, 'Juan XIII La Quiebra' => 8000, 'La Divisa' => 7500, 'Veinte de Julio' => 7500, 'Belencito' => 7000, 'Betania' => 8000, 'El Corazón' => 8000, 'Las Independencias' => 8500, 'Nuevos Conquistadores' => 8500, 'El Salado' => 8500, 'Eduardo Santos' => 7500, 'Peñitas' => 8000, 'Antonio Nariño' => 7500, 'El Socorro' => 8000,
                // Comuna 14 - El Poblado
                'El Poblado' => 6000, 'Barrio Colombia' => 5000, 'Simesa' => 5000, 'Villa Carlota' => 5500, 'Castropol' => 6000, 'Lalinde' => 6500, 'Las Lomas No.1' => 7000, 'Las Lomas No.2' => 7000, 'Altos del Poblado' => 8000, 'El Tesoro' => 7500, 'Los Naranjos' => 7000, 'Los Balsos No.1' => 7500, 'Los Balsos No.2' => 7500, 'San Lucas' => 8000, 'El Diamante No.2' => 7000, 'El Castillo' => 7500, 'Alejandría' => 6000, 'La Florida' => 6500, 'Manila' => 5500, 'Astorga' => 5500, 'Patio Bonito' => 5000, 'La Aguacatala' => 5000, 'Santa María de los Ángeles' => 5500,
                // Comuna 15 - Guayabal
                'Guayabal' => 4000, 'Tenche' => 4000, 'Trinidad' => 3500, 'Santa Fe' => 4000, 'Shellmar' => 4000, 'San Pablo' => 4500, 'Parque Juan Pablo II' => 4000, 'Campo Amor' => 3500, 'Noel' => 3500, 'Cristo Rey' => 3500, 'La Colina' => 4500,
                // Comuna 16 - Belén
                'Belén' => 3000, 'Fátima' => 3000, 'Rosales' => 3500, 'Granada' => 3500, 'San Bernardo' => 3500, 'Las Playas' => 3000, 'Diego Echavarría' => 4000, 'La Mota' => 4000, 'La Hondonada' => 4500, 'El Rincón' => 4000, 'Loma de los Bernal' => 4500, 'La Gloria' => 4000, 'La Palma' => 3500, 'Zafra' => 4000, 'Los Alpes' => 3500, 'Las Violetas' => 4000, 'Las Mercedes' => 3500, 'Nueva Villa de Aburrá' => 4000, 'Miravalle' => 4500, 'El Nogal Los Almendros' => 4500, 'Cerro Nutibara' => 5000,
                // Corregimientos
                'Altavista' => 7000, 'San Antonio de Prado' => 9000, 'San Cristóbal' => 12000, 'Palmitas' => 15000, 'Santa Elena' => 16000,
            ],
            'Copacabana' => [
                'Ancón' => 12000, 'Asunción' => 12500, 'Canoas' => 13000, 'Centro' => 12000, 'Cristo Rey' => 12500, 'El Recreo' => 12500, 'El Pedregal' => 13000, 'Fátima' => 12500, 'La Azulita' => 13500, 'La Misericordia' => 13000, 'La Pedrera' => 13500, 'Las Catas' => 13000, 'Miraflores' => 13000, 'Remanso' => 12500, 'San Juan' => 12500, 'Tobón Quintero' => 12500, 'Villa Nueva' => 12500, 'Yarumito' => 14000,
            ],
            'Girardota' => [
                'Centro' => 15000, 'El Llano' => 15500, 'El Paraíso' => 16000, 'El Salado' => 16000, 'Guayacanes' => 15500, 'Juan XXIII' => 15500, 'La Ceiba' => 15500, 'La Ferrería' => 16000, 'Naranjal' => 15500, 'San José' => 15000, 'Santa Ana' => 15500, 'La Palma' => 16500, 'El Totumo' => 17000,
            ],
            'Barbosa' => [
                'Aguas Claras' => 18000, 'Barrios de Jesús' => 18500, 'Buenos Aires' => 18500, 'Centro' => 18000, 'El Portón' => 18500, 'El Progreso' => 18500, 'El Paraíso' => 19000, 'La Esmeralda' => 19000, 'Pepe Sierra' => 19000, 'Santa Mónica' => 18500, 'Las Orquídeas' => 19500, 'El Socorro' => 19500,
            ],
            'La Estrella' => [
                'Bellavista' => 9000, 'Cañaveralejo' => 9500, 'Ancón' => 9500, 'San Agustín' => 9000, 'San Andrés' => 9000, 'Horizontes' => 10000, 'Quebrada Grande' => 10500, 'La Ferrería' => 9500, 'El Pedrero' => 10000, 'La Tablaza' => 10500, 'Pueblo Viejo' => 9000, 'La Cuchilla' => 9500, 'La Inmaculada' => 9000, 'San Cayetano' => 9500, 'San Vicente' => 9500, 'Sierra Morena' => 10000, 'El Guamúchil' => 10000, 'Buenos Aires' => 9500, 'El Dorado' => 9500, 'La Chinca' => 9500,
            ],
            'Caldas' => [
                'La Inmaculada' => 12000, 'La Acuarela' => 12500, 'El Campestre' => 13000, 'La Planta' => 12000, 'El Salazar' => 12500, 'Mandalay' => 12500, 'La vereda La Corrala' => 14000, 'El Alto de la Virgen' => 13500, 'Los Cerezos' => 12500, 'Las Margaritas' => 12000, 'El Triángulo' => 12000, 'La Locería' => 13000, 'La Inmaculada Concepción' => 12000, 'Las Salinas' => 13500,
            ],
            'Sabaneta' => [
                'Aliadas del Sur' => 8000, 'Ancón Sur' => 8500, 'Aves María' => 8500, 'Betania' => 8000, 'Calle del Banco' => 7500, 'Calle Larga' => 7500, 'El Carmelo' => 8000, 'El Centro' => 7500, 'El Comienzo' => 8500, 'El Jordán' => 8500, 'El Trapiche' => 8500, 'Entreamigos' => 8000, 'Holanda' => 8000, 'La Barquereña' => 8000, 'La Doctora' => 9000, 'Las Casitas' => 8000, 'Las Lomitas' => 9000, 'Los Alcázares' => 8000, 'Los Arias' => 8500, 'María Auxiliadora' => 8500, 'Mayorista' => 7500, 'Nuestra Señora de los Dolores' => 8000, 'Paso Ancho' => 8000, 'Playas de María' => 8000, 'Prado de Sabaneta' => 8000, 'Restrepo Naranjo' => 8000, 'San Joaquín' => 8000, 'San Rafael' => 8500, 'Tres Esquinas' => 8000, 'Virgen del Carmen' => 8500,
            ],
            'Envigado' => [
                'El Centro' => 7000, 'El Trianón' => 7500, 'La Magnolia' => 7000, 'Las Vegas' => 6500, 'Alcalá' => 7000, 'El Portal' => 7500, 'La Paz' => 7500, 'El Dorado' => 7500, 'Zúñiga' => 7000, 'Jardines' => 7500, 'Señorial' => 8000, 'La Sebastiana' => 8500, 'El Chingui' => 8500, 'El Salado' => 9000, 'La Mina' => 8500, 'Obrero' => 7000, 'Pontevedra' => 7000, 'San Marcos' => 7500, 'Las Antillas' => 7500, 'Las Flores' => 7500, 'Loma del Barro' => 9000, 'El Escobero' => 9500, 'Loma de las Brujas' => 9500, 'El Chocho' => 10000,
            ],
            'Bello' => [
                'Niquía' => 10000, 'La Cumbre' => 11500, 'El Congolo' => 11000, 'La Selva' => 11000, 'Urapanes' => 10500, 'El Cairo' => 11000, 'El Porvenir' => 11000, 'La Cabañita' => 10500, 'La Cabaña' => 10500, 'La Florida' => 10500, 'Buenos Aires' => 11000, 'Pérez' => 10500, 'El Carmelo' => 11000, 'El Paraíso' => 12000, 'Pachelly' => 12500, 'San Gabriel' => 12500, 'La Primavera' => 11000, 'La Palma' => 10500, 'La Aldea' => 11500, 'La Gabriela' => 12000, 'Las Granjas' => 11000, 'La Madera' => 10500, 'La Estación' => 10000, 'Santa Ana' => 10500, 'Espíritu Santo' => 11000, 'La Mesa' => 12000, 'El Tapón' => 11500, 'Machado' => 11500, 'El Centro' => 11000, 'Suárez' => 10500, 'Puerto Bello' => 10000, 'Central' => 11000, 'Rincón Santo' => 11000, 'La Milagrosa' => 11500, 'El Rosario' => 11000, 'Santana' => 11500, 'Serramonte' => 11000, 'Mánchester' => 11000, 'La Guayana' => 11000, 'El Ducado' => 10500, 'El Trapiche' => 12000, 'La Amazonia' => 12000, 'La Virginia' => 11500, 'Goretti' => 11500, 'El Mirador' => 12500, 'Valadares' => 11500, 'Hato Viejo' => 12000, 'El Guasimal' => 12000, 'La Navarra' => 11500, 'La Inspección' => 11000, 'El Choco' => 12500, 'Bellavista' => 11500, 'Tierradentro' => 12000, 'La Maruchenga' => 12500, 'París' => 13000, 'San José Obrero' => 12000, 'Nueva Jerusalén' => 13500, 'Prado' => 10500, 'La Esmeralda' => 11000, 'La Providencia' => 11000,
            ],
             'Itagüí' => [
                'Centro' => 5500, 'El Rosario' => 5500, 'Playa Rica' => 6000, 'Asturias' => 5500, 'La Independencia' => 6000, 'La Gloria' => 6000, 'Araucaria' => 5500, 'Artex' => 5000, 'San Pío X' => 5500, 'La Palma' => 6000, 'Monte Verde' => 6500, 'El Tablazo' => 6500, 'Las Acacias' => 5500, 'Fátima' => 5000, 'El Carmen' => 5000, 'Las Mercedes' => 5000, 'Simón Bolívar' => 5500, 'La Finquita' => 5500, 'San Fernando' => 5500, 'Santa María No. 1' => 5000, 'Santa María No. 2' => 5000, 'Santa María No. 3 La Terraza' => 5500, 'San Pablo' => 5500, 'San Isidro' => 6000, 'La Unión' => 6000, 'Santa Ana' => 6000, 'Samaria' => 6500, 'Las Margaritas' => 6500, 'San Javier' => 6000, 'Villa Paula' => 6500, 'Zona Industrial No. 1' => 6000, 'Zona Industrial No. 2' => 6500, 'Zona Industrial No. 3' => 7000, 'San José' => 5500, 'Glorieta Pilsen' => 5500, 'Villa Lía' => 6000, '19 de Abril' => 6000, 'Pilsen' => 5500, 'Los Naranjos' => 6000, 'Los Gómez' => 6000, 'Santa Catalina' => 6000, 'San Antonio' => 6500, 'El Ajizal' => 7000, 'El Pedregal' => 6500, 'Los Olivares' => 6500, 'La María' => 6000, 'El Progreso' => 6500, 'Loma Linda' => 6500, 'Porvenir' => 6500,
            ],
        ];

        foreach ($zones as $municipality => $neighborhoods) {
            foreach ($neighborhoods as $neighborhood => $price) {
                ShippingZone::create([
                    'municipality' => $municipality,
                    'neighborhood' => $neighborhood,
                    'price' => $price,
                ]);
            }
        }
        
        $this->command->info('¡Seeder maestro finalizado! Se cargaron todos los barrios del Valle de Aburrá. La base de datos está 100% completa.');
    }
}
