<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    public function run()
    {
        $departamentos = [
            [
                'nombre' => 'Tecnologías de la Información',
                'descripcion' => 'Departamento encargado de sistemas y tecnología',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Gestión de personal y talento humano',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Contabilidad',
                'descripcion' => 'Manejo financiero y contable de la empresa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Ventas y Marketing',
                'descripcion' => 'Departamento comercial y de promoción',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Operaciones',
                'descripcion' => 'Gestión de procesos operativos',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('departamentos')->insert($departamentos);
    }
}