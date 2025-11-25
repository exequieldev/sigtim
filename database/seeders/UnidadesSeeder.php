<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesSeeder extends Seeder
{
    public function run()
    {
        $unidades = [
            ['nombre' => 'Gigahercios', 'simbolo' => 'GHz', 'descripcion' => 'Frecuencia de CPU'],
            ['nombre' => 'Megahercios', 'simbolo' => 'MHz', 'descripcion' => 'Frecuencia de RAM'],
            ['nombre' => 'Gigabytes', 'simbolo' => 'GB', 'descripcion' => 'Memoria RAM, Almacenamiento'],
            ['nombre' => 'Terabytes', 'simbolo' => 'TB', 'descripcion' => 'Almacenamiento grande'],
            ['nombre' => 'Megabytes', 'simbolo' => 'MB', 'descripcion' => 'Memoria de video, caché'],
            ['nombre' => 'Gigabytes VRAM', 'simbolo' => 'GB_VRAM', 'descripcion' => 'Memoria de video dedicada'],
            ['nombre' => 'Núcleos', 'simbolo' => 'Cores', 'descripcion' => 'Núcleos de CPU'],
            ['nombre' => 'Hilos', 'simbolo' => 'Threads', 'descripcion' => 'Hilos de CPU'],
            ['nombre' => 'Bits', 'simbolo' => 'Bits', 'descripcion' => 'Arquitectura (32/64 bits)'],
            ['nombre' => 'Watts', 'simbolo' => 'Watts', 'descripcion' => 'Consumo energético'],
            ['nombre' => 'Revoluciones por minuto', 'simbolo' => 'RPM', 'descripcion' => 'Velocidad de discos duros'],
            ['nombre' => 'Gigabytes por segundo', 'simbolo' => 'GB/s', 'descripcion' => 'Ancho de banda'],
            ['nombre' => 'Unidad', 'simbolo' => 'Unidad', 'descripcion' => 'Para componentes sin unidad específica'],
            ['nombre' => 'No aplica', 'simbolo' => 'N/A', 'descripcion' => 'No aplica'],
        ];

        DB::table('unidades')->insert($unidades);
    }
}