<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('programa_requisitos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programa_id')->constrained('programas');
            $table->foreignId('tipo_componente_id')->constrained('tipos_componente');
            $table->string('requisito_minimo');
            $table->string('requisito_recomendado')->nullable();
            
            // Columna para las unidades de medida
            $table->enum('unidad_medida', [
                'GHz',        // Frecuencia de CPU
                'MHz',        // Frecuencia de RAM
                'GB',         // Memoria RAM, Almacenamiento
                'TB',         // Almacenamiento grande
                'MB',         // Memoria de video, caché
                'GB_VRAM',    // Memoria de video dedicada
                'Cores',      // Núcleos de CPU
                'Threads',    // Hilos de CPU
                'Bits',       // Arquitectura (32/64 bits)
                'Watts',      // Consumo energético
                'RPM',        // Velocidad de discos duros
                'GB_s',       // Ancho de banda
                'Unidad',     // Para componentes sin unidad específica
                'N/A'         // No aplica
            ])->default('Unidad');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programa_requisitos');
    }
};