<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposComponenteSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'nombre' => 'Procesador',
                'descripcion' => 'Unidad central de procesamiento'
            ],
            [
                'nombre' => 'Memoria RAM',
                'descripcion' => 'Memoria de acceso aleatorio'
            ],
            [
                'nombre' => 'Almacenamiento',
                'descripcion' => 'Discos duros y unidades de estado sólido'
            ],
            [
                'nombre' => 'Tarjeta Madre',
                'descripcion' => 'Placa base del equipo'
            ],
            [
                'nombre' => 'Tarjeta de Video',
                'descripcion' => 'Unidad de procesamiento gráfico'
            ],
            [
                'nombre' => 'Fuente de Poder',
                'descripcion' => 'Fuente de alimentación'
            ]
        ];

        DB::table('tipos_componente')->insert($tipos);
    }
}