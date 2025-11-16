<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSolicitudesSeeder extends Seeder
{
    public function run()
    {
        $tiposSolicitud = [
            [
                'nombre' => 'Adquisición',
                'descripcion' => 'Solicitud para adquirir nuevos equipos o componentes'
            ],
            [
                'nombre' => 'Reposición',
                'descripcion' => 'Solicitud para reemplazar equipos o componentes existentes'
            ],
            [
                'nombre' => 'Reparación',
                'descripcion' => 'Solicitud para reparar equipos o componentes dañados'
            ],
            [
                'nombre' => 'Almacenamiento',
                'descripcion' => 'Solicitud relacionada con almacenamiento de equipos o componentes'
            ]
        ];

        DB::table('tipo_solicitudes')->insert($tiposSolicitud);
    }
}