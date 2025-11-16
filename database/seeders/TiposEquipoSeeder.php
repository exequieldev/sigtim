<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEquipoSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'nombre' => 'Computadora de Escritorio',
                'descripcion' => 'Equipos de computación para uso en oficina'
            ],
            [
                'nombre' => 'Laptop',
                'descripcion' => 'Computadoras portátiles'
            ],
            [
                'nombre' => 'Servidor',
                'descripcion' => 'Equipos para servicios de red y aplicaciones'
            ],
            [
                'nombre' => 'Impresora',
                'descripcion' => 'Equipos de impresión'
            ],
            [
                'nombre' => 'Switch de Red',
                'descripcion' => 'Equipos de networking'
            ],
            [
                'nombre' => 'Monitor',
                'descripcion' => 'Pantallas para computadoras'
            ]
        ];

        DB::table('tipos_equipo')->insert($tipos);
    }
}