<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empleado_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->date('fecha_asignacion')->default(now());
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Asegurar que la combinación empleado-equipo sea única
            $table->unique(['empleado_id', 'equipo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleado_equipo');
    }
};