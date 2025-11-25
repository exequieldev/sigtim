<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitud_diagnostico', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('solicitud_id')->constrained('solicitudes')->onDelete('cascade');
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade');
            
            // Información adicional específica de la relación
            $table->date('fecha_asignacion')->default(now());
            $table->enum('estado_asignacion', ['pendiente', 'asignado', 'en_proceso', 'completado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            
            // Campos de auditoría
            $table->timestamps();
            
            // Asegurar que la combinación solicitud-diagnóstico sea única
            $table->unique(['solicitud_id', 'diagnostico_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_diagnostico');
    }
};