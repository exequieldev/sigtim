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
        Schema::create('equipo_accesorio', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('equipo_id')
                  ->constrained('equipos')
                  ->onDelete('cascade');
                  
            $table->foreignId('accesorio_id')
                  ->constrained('accesorios')
                  ->onDelete('cascade');
            
            // Campo activo
            $table->boolean('activo')->default(true);
            
            // Restricción única: accesorio_id + activo
            $table->unique(['accesorio_id', 'activo']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_accesorio');
    }
};