<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramasSeeder extends Seeder
{
    public function run()
    {
        $programas = [
            [
                'nombre' => 'Adobe Photoshop',
                'descripcion' => 'Editor de imágenes y gráficos rasterizados',
                'version' => '2024',
                'fabricante_id' => 1, // Adobe Inc.
                'sistema_operativo' => 'Windows, macOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Visual Studio Code',
                'descripcion' => 'Editor de código fuente desarrollado por Microsoft',
                'version' => '1.85',
                'fabricante_id' => 2, // Microsoft
                'sistema_operativo' => 'Windows, Linux, macOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Microsoft Excel',
                'descripcion' => 'Hoja de cálculo para análisis de datos',
                'version' => '365',
                'fabricante_id' => 2, // Microsoft
                'sistema_operativo' => 'Windows, macOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'AutoCAD',
                'descripcion' => 'Software de diseño CAD para dibujo 2D y 3D',
                'version' => '2024',
                'fabricante_id' => 3, // Autodesk
                'sistema_operativo' => 'Windows, macOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tableau',
                'descripcion' => 'Herramienta de visualización de datos y business intelligence',
                'version' => '2023.3',
                'fabricante_id' => 4, // Tableau
                'sistema_operativo' => 'Windows, macOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Google Chrome',
                'descripcion' => 'Navegador web rápido y seguro',
                'version' => '120',
                'fabricante_id' => 5, // Google
                'sistema_operativo' => 'Windows, Linux, macOS, Android, iOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'WordPress',
                'descripcion' => 'Sistema de gestión de contenidos para crear sitios web',
                'version' => '6.4',
                'fabricante_id' => 6, // WordPress Foundation
                'sistema_operativo' => 'Web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Slack',
                'descripcion' => 'Plataforma de colaboración y comunicación empresarial',
                'version' => '4.32',
                'fabricante_id' => 7, // Salesforce
                'sistema_operativo' => 'Windows, Linux, macOS, Web, Mobile',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Zoom',
                'descripcion' => 'Plataforma de videoconferencias y reuniones virtuales',
                'version' => '5.17',
                'fabricante_id' => 8, // Zoom Video Communications
                'sistema_operativo' => 'Windows, macOS, Linux, Web, Mobile',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Trello',
                'descripcion' => 'Herramienta de gestión de proyectos y organización de tareas',
                'version' => '2023',
                'fabricante_id' => 9, // Atlassian
                'sistema_operativo' => 'Web, Windows, macOS, Mobile',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('programas')->insert($programas);
    }
}