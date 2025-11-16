<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {
        $proveedores = [
            [
                'razon_social' => 'TecnoSuministros S.A.',
                'cuit' => '30-12345678-9',
                'email' => 'ventas@tecnosuministros.com',
                'tipo_servicio_id' => 1,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'razon_social' => 'CompuParts Internacional',
                'cuit' => '30-23456789-1',
                'email' => 'info@compuparts.com',
                'tipo_servicio_id' => 1,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'razon_social' => 'Hardware Global',
                'cuit' => '30-34567891-2',
                'email' => 'contacto@hardwareglobal.com',
                'tipo_servicio_id' => 2,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'razon_social' => 'ElectroComponentes Ltda.',
                'cuit' => '30-45678912-3',
                'email' => 'ventas@electrocomponentes.com',
                'tipo_servicio_id' => 2,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'razon_social' => 'TechSuppliers Corp.',
                'cuit' => '30-56789123-4',
                'email' => 'orders@techsuppliers.com',
                'tipo_servicio_id' => 3,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('proveedores')->insert($proveedores);
    }
}