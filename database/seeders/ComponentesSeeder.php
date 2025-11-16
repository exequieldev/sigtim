<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentesSeeder extends Seeder
{
    public function run()
    {
        $componentes = [
            [
                
                'tipo_componente_id' => 1, // Procesador
                'fabricante_id' => 5, // Intel
                'modelo' => 'Core i7-12700K',
                'especificaciones' => '12 núcleos, 20 hilos, 3.6GHz',
                'numero_serie' => 'INT12700K12345',
                'fecha_adquisicion' => '2023-01-15',
                'fecha_instalacion' => '2023-01-20'
            ],
            [
                
                'tipo_componente_id' => 2, // RAM
                'fabricante_id' => 6, // Samsung
                'modelo' => 'DDR4 16GB',
                'especificaciones' => '16GB DDR4 3200MHz',
                'numero_serie' => 'SAMDDR416G67890',
                'fecha_adquisicion' => '2023-02-10',
                'fecha_instalacion' => '2023-02-15'
            ],
            [
                
                'tipo_componente_id' => 3, // Almacenamiento
                'fabricante_id' => 6, // Samsung
                'modelo' => 'SSD 970 EVO',
                'especificaciones' => '1TB NVMe M.2',
                'numero_serie' => 'SAM970EVO11111',
                'fecha_adquisicion' => '2023-03-05',
                'fecha_instalacion' => '2023-03-10'
            ],
            [
                
                'tipo_componente_id' => 4, // Tarjeta Madre
                'fabricante_id' => 2, // HP
                'modelo' => 'Z490',
                'especificaciones' => 'Socket LGA1200, ATX',
                'numero_serie' => 'HPZ490MB22222',
                'fecha_adquisicion' => '2023-01-12',
                'fecha_instalacion' => '2023-01-18'
            ],
            [
                
                'tipo_componente_id' => 5, // Tarjeta de Video
                'fabricante_id' => 1, // Dell
                'modelo' => 'RTX 3060',
                'especificaciones' => '12GB GDDR6',
                'numero_serie' => 'DELRTX30603333',
                'fecha_adquisicion' => '2023-04-20',
                'fecha_instalacion' => '2023-04-25'
            ]
        ];

        DB::table('componentes')->insert($componentes);
    }
}