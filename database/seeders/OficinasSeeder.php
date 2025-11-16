<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OficinasSeeder extends Seeder
{
    public function run()
    {
        $oficinas = [
            [
                'nombre' => 'Oficina de Sistemas',
                'descripcion' => 'Oficina principal del área de TI',
                'departamento_id' => 1
            ],
            [
                'nombre' => 'Oficina de Desarrollo',
                'descripcion' => 'Área de desarrollo de software',
                'departamento_id' => 1
            ],
            [
                'nombre' => 'Oficina de Reclutamiento',
                'descripcion' => 'Selección y contratación de personal',
                'departamento_id' => 2
            ],
            [
                'nombre' => 'Oficina Contable',
                'descripcion' => 'Gestión financiera y contable',
                'departamento_id' => 3
            ],
            [
                'nombre' => 'Oficina Comercial',
                'descripcion' => 'Ventas y atención al cliente',
                'departamento_id' => 4
            ]
        ];

        DB::table('oficinas')->insert($oficinas);
    }
}