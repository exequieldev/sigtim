<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            [
                'nombre' => 'Gerente General',
                'descripcion' => 'Responsable de la dirección y administración general de la empresa'
            ],
            [
                'nombre' => 'Jefe de Departamento',
                'descripcion' => 'Encargado de supervisar y coordinar las actividades de un departamento'
            ],
            [
                'nombre' => 'Analista Senior',
                'descripcion' => 'Profesional con experiencia en análisis y desarrollo de proyectos'
            ],
            [
                'nombre' => 'Desarrollador Backend',
                'descripcion' => 'Especialista en desarrollo del lado del servidor y lógica de negocio'
            ],
            [
                'nombre' => 'Desarrollador Frontend',
                'descripcion' => 'Especialista en desarrollo de interfaces de usuario y experiencia de usuario'
            ],
            [
                'nombre' => 'Administrador de Sistemas',
                'descripcion' => 'Responsable del mantenimiento y configuración de sistemas informáticos'
            ],
            [
                'nombre' => 'Especialista en Base de Datos',
                'descripcion' => 'Encargado del diseño, implementación y mantenimiento de bases de datos'
            ],
            [
                'nombre' => 'Diseñador UX/UI',
                'descripcion' => 'Profesional especializado en experiencia e interfaz de usuario'
            ],
            [
                'nombre' => 'Asistente Administrativo',
                'descripcion' => 'Apoyo en labores administrativas y de oficina'
            ],
            [
                'nombre' => 'Practicante',
                'descripcion' => 'Estudiante en etapa de prácticas profesionales'
            ]
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }

        $this->command->info('Tabla de cargos poblada exitosamente.');
    }
}