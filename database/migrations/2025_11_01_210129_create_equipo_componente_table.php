<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipo_componente', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('equipo_id')
                  ->constrained('equipos')
                  ->onDelete('cascade');
                  
            $table->foreignId('componente_id')
                  ->constrained('componentes')
                  ->onDelete('cascade');
            
            // Campo activo
            $table->boolean('activo')->default(true);
            
            // Restricción única: componente_id + activo
            $table->unique(['componente_id', 'activo']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_componente');
    }
};