<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FabricantesSeeder extends Seeder
{
    public function run()
    {
        $fabricantes = [
            ['nombre' => 'Adobe Inc.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Microsoft', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Autodesk', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tableau', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Google', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'WordPress Foundation', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Salesforce', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Zoom Video Communications', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Atlassian', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('fabricantes')->insert($fabricantes);
    }
}