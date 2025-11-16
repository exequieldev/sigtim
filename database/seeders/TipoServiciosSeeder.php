<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServiciosSeeder extends Seeder
{
    public function run()
    {
        $tiposServicio = [
            [
                'nombre' => 'Hardware',
                'descripcion' => 'Suministro de componentes y equipos físicos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Software',
                'descripcion' => 'Licencias y desarrollo de software',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Soporte Técnico',
                'descripcion' => 'Servicios de mantenimiento y soporte técnico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Redes',
                'descripcion' => 'Equipos y servicios de networking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Consultoría IT',
                'descripcion' => 'Servicios de consultoría tecnológica',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('tipo_servicios')->insert($tiposServicio);
    }
}