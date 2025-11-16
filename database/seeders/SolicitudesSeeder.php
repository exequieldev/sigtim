<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitudesSeeder extends Seeder
{
    public function run()
    {
        $solicitudes = [
            [
                'fecha_inicio' => '2024-01-15',
                'estado' => 'aprobada',
                'empleado_id' => 1,
                'tipo_solicitud_id' => 1 // Adquisición
            ],
            [
                'fecha_inicio' => '2024-01-20',
                'estado' => 'en_proceso',
                'empleado_id' => 3,
                'tipo_solicitud_id' => 3 // Reparación
            ],
            [
                'fecha_inicio' => '2024-01-25',
                'estado' => 'pendiente',
                'empleado_id' => 4,
                'tipo_solicitud_id' => 2 // Reposición
            ],
            [
                'fecha_inicio' => '2024-02-01',
                'estado' => 'completada',
                'empleado_id' => 2,
                'tipo_solicitud_id' => 4 // Almacenamiento
            ],
            [
                'fecha_inicio' => '2024-02-05',
                'estado' => 'aprobada',
                'empleado_id' => 5,
                'tipo_solicitud_id' => 2 // Reposición
            ]
        ];

        DB::table('solicitudes')->insert($solicitudes);

        // Relaciones solicitud-actividad (tabla pivote)
        $solicitudActividades = [
            ['solicitud_id' => 1, 'actividad_id' => 1], // Diseño Gráfico
            ['solicitud_id' => 1, 'actividad_id' => 2], // Desarrollo de Software
            ['solicitud_id' => 2, 'actividad_id' => 4], // Administración
            ['solicitud_id' => 3, 'actividad_id' => 2], // Desarrollo de Software
            ['solicitud_id' => 3, 'actividad_id' => 3], // Análisis de Datos
            ['solicitud_id' => 4, 'actividad_id' => 4], // Administración
            ['solicitud_id' => 5, 'actividad_id' => 1]  // Diseño Gráfico
        ];

        DB::table('solicitud_actividad')->insert($solicitudActividades);
    }
}