<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitud_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->text('descripcion_uso')->nullable(); // Para especificar cómo se usará el equipo en esta solicitud
            $table->integer('cantidad')->default(1); // Cantidad de equipos si aplica
            $table->date('fecha_asignacion')->nullable(); // Nueva columna para fecha de asignación
            $table->enum('estado_asignacion', ['pendiente', 'en_proceso', 'completado'])->default('pendiente'); // Nueva columna para estado
            $table->text('observaciones')->nullable(); // Nueva columna para observaciones
            $table->timestamps();
            
            // Índice único para evitar duplicados
            $table->unique(['solicitud_id', 'equipo_id']);

        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_equipo');
    }
};