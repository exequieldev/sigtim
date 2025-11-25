<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposFabricanteSeeder extends Seeder
{
    public function run()
    {
        $tiposFabricante = [
            [
                'nombre' => 'Software y Aplicaciones',
                'descripcion' => 'Desarrolladores de software, aplicaciones y programas informáticos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Hardware y Componentes',
                'descripcion' => 'Fabricantes de componentes de hardware como procesadores, memorias, etc.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Sistemas Operativos',
                'descripcion' => 'Desarrolladores de sistemas operativos y plataformas base',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Nube y Servicios Online',
                'descripcion' => 'Proveedores de servicios en la nube y plataformas online',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Herramientas de Desarrollo',
                'descripcion' => 'Creadores de herramientas para desarrolladores y programadores',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Seguridad Informática',
                'descripcion' => 'Especialistas en software de seguridad y protección',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Open Source',
                'descripcion' => 'Comunidades y fundaciones de software de código abierto',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('tipos_fabricante')->insert($tiposFabricante);
    }
}