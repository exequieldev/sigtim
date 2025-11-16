<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            TiposEquipoSeeder::class,
            FabricantesSeeder::class,
            TiposComponenteSeeder::class,
            EquiposSeeder::class,
            ComponentesSeeder::class,
            TipoServiciosSeeder::class,
            ProveedoresSeeder::class,
            ActividadesSeeder::class,
            ProgramasSeeder::class,
            DepartamentosSeeder::class,
            OficinasSeeder::class,
            EmpleadosSeeder::class,
            TipoSolicitudesSeeder::class,
            SolicitudesSeeder::class,
            ComponentesSeeder::class,
        ]);
    }
}