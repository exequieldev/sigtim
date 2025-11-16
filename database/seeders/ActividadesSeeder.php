<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActividadesSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        $actividades = [
            [
                'nombre' => 'Diseño Gráfico',
                'descripcion' => 'Actividades relacionadas con diseño y edición de gráficos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Desarrollo de Software',
                'descripcion' => 'Programación y desarrollo de aplicaciones',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Análisis de Datos',
                'descripcion' => 'Procesamiento y análisis de grandes volúmenes de datos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Administración',
                'descripcion' => 'Tareas administrativas y ofimáticas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Ingeniería CAD/CAM',
                'descripcion' => 'Diseño asistido por computadora y manufactura',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('actividades')->insert($actividades);
    }
}