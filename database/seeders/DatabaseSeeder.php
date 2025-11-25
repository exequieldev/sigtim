<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            TiposEquipoSeeder::class,
            TiposFabricanteSeeder::class,
            FabricantesSeeder::class,
            TiposComponenteSeeder::class,
            DepartamentosSeeder::class,
            OficinasSeeder::class,
            CargoSeeder::class, 
            UnidadesSeeder::class,
            EquiposSeeder::class,
            ComponentesSeeder::class,
            TipoServiciosSeeder::class,
            ProveedoresSeeder::class,
            ActividadesSeeder::class,
            ProgramasSeeder::class,
            EmpleadosSeeder::class, 
            TipoSolicitudesSeeder::class,
            SolicitudesSeeder::class,
        ]);
    }
}