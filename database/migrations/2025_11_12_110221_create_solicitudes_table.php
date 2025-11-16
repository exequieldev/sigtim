<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'en_proceso', 'completada'])->default('pendiente');
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->foreignId('tipo_solicitud_id')->constrained('tipo_solicitudes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
};