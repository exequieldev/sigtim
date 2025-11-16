<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquiposSeeder extends Seeder
{
    public function run()
    {
        $equipos = [
            [
                'numero_serie' => 'DELPC0012023',
                'tipo_equipo_id' => 1, // Computadora de Escritorio
                'fabricante_id' => 1, // Dell
                'modelo' => 'OptiPlex 7090',
                'estado' => 'Activo',
                'fecha_adquisicion' => '2023-05-01',
                'fecha_instalacion' => '2023-05-05',
                'descripcion' => 'Equipo para área de contabilidad'
            ],
            [
                'numero_serie' => 'HPLT0022023',
                'tipo_equipo_id' => 2, // Laptop
                'fabricante_id' => 2, // HP
                'modelo' => 'EliteBook 840 G8',
                'estado' => 'Activo',
                'fecha_adquisicion' => '2023-06-15',
                'fecha_instalacion' => '2023-06-20',
                'descripcion' => 'Laptop para gerente de ventas'
            ],
            [
                'numero_serie' => 'LENSV0032023',
                'tipo_equipo_id' => 3, // Servidor
                'fabricante_id' => 3, // Lenovo
                'modelo' => 'ThinkSystem SR650',
                'estado' => 'Activo',
                'fecha_adquisicion' => '2023-03-10',
                'fecha_instalacion' => '2023-03-15',
                'descripcion' => 'Servidor principal de la empresa'
            ],
            [
                'numero_serie' => 'HPIP0042023',
                'tipo_equipo_id' => 4, // Impresora
                'fabricante_id' => 2, // HP
                'modelo' => 'LaserJet Pro M404dn',
                'estado' => 'Mantenimiento',
                'fecha_adquisicion' => '2022-11-20',
                'fecha_instalacion' => '2022-11-25',
                'descripcion' => 'Impresora de área administrativa'
            ],
            [
                'numero_serie' => 'CISSW0052023',
                'tipo_equipo_id' => 5, // Switch de Red
                'fabricante_id' => 4, // Cisco
                'modelo' => 'Catalyst 2960X',
                'estado' => 'Activo',
                'fecha_adquisicion' => '2023-02-28',
                'fecha_instalacion' => '2023-03-05',
                'descripcion' => 'Switch para piso 3'
            ],
            [
                'numero_serie' => 'SAMMN0062023',
                'tipo_equipo_id' => 6, // Monitor
                'fabricante_id' => 6, // Samsung
                'modelo' => 'S24F350',
                'estado' => 'En Reparación',
                'fecha_adquisicion' => '2023-07-10',
                'fecha_instalacion' => '2023-07-12',
                'descripcion' => 'Monitor 24" para recepción'
            ]
        ];

        DB::table('equipos')->insert($equipos);
    }
}