<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadosSeeder extends Seeder
{
    public function run()
    {
        $empleados = [
            [
                'nombre' => 'Ana',
                'apellido' => 'García',
                'email' => 'ana.garcia@empresa.com',
                'telefono' => '+1234567890',
                'cargo' => 'Desarrolladora Senior',
                'oficina_id' => 2
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'email' => 'carlos.rodriguez@empresa.com',
                'telefono' => '+1234567891',
                'cargo' => 'Administrador de Sistemas',
                'oficina_id' => 1
            ],
            [
                'nombre' => 'María',
                'apellido' => 'López',
                'email' => 'maria.lopez@empresa.com',
                'telefono' => '+1234567892',
                'cargo' => 'Reclutadora',
                'oficina_id' => 3
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Martínez',
                'email' => 'juan.martinez@empresa.com',
                'telefono' => '+1234567893',
                'cargo' => 'Contador',
                'oficina_id' => 4
            ],
            [
                'nombre' => 'Laura',
                'apellido' => 'Hernández',
                'email' => 'laura.hernandez@empresa.com',
                'telefono' => '+1234567894',
                'cargo' => 'Ejecutiva de Ventas',
                'oficina_id' => 5
            ]
        ];

        DB::table('empleados')->insert($empleados);
    }
}