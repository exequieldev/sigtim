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
            [
                'nombre' => 'Adobe Inc.', 
                'tipo_fabricante_id' => 1, // Software y Aplicaciones
                'contacto' => 'soporte@adobe.com',
                'telefono' => '+1-800-833-6687',
                'email' => 'enterprise@adobe.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Microsoft', 
                'tipo_fabricante_id' => 3, // Sistemas Operativos
                'contacto' => 'Soporte Enterprise',
                'telefono' => '+1-800-642-7676',
                'email' => 'enterprise@microsoft.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Autodesk', 
                'tipo_fabricante_id' => 1, // Software y Aplicaciones
                'contacto' => 'Soporte Técnico',
                'telefono' => '+1-855-664-8618',
                'email' => 'support@autodesk.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Tableau', 
                'tipo_fabricante_id' => 1, // Software y Aplicaciones
                'contacto' => 'Sales Department',
                'telefono' => '+1-206-633-3400',
                'email' => 'sales@tableau.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Google', 
                'tipo_fabricante_id' => 4, // Nube y Servicios Online
                'contacto' => 'Google Cloud Support',
                'telefono' => '+1-877-355-5787',
                'email' => 'cloud-support@google.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'WordPress Foundation', 
                'tipo_fabricante_id' => 7, // Open Source
                'contacto' => 'Community Support',
                'telefono' => null,
                'email' => 'foundation@wordpress.org',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Salesforce', 
                'tipo_fabricante_id' => 4, // Nube y Servicios Online
                'contacto' => 'Customer Success',
                'telefono' => '+1-800-667-6389',
                'email' => 'enterprise@salesforce.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Zoom Video Communications', 
                'tipo_fabricante_id' => 4, // Nube y Servicios Online
                'contacto' => 'Business Support',
                'telefono' => '+1-888-799-9666',
                'email' => 'business@zoom.us',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nombre' => 'Atlassian', 
                'tipo_fabricante_id' => 5, // Herramientas de Desarrollo
                'contacto' => 'Enterprise Support',
                'telefono' => '+1-800-10-0049',
                'email' => 'enterprise@atlassian.com',
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ];

        DB::table('fabricantes')->insert($fabricantes);
    }
}