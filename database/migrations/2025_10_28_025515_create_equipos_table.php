<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_serie')->unique();
            $table->foreignId('tipo_equipo_id')->constrained('tipos_equipo');
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->string('modelo');
            $table->enum('estado', ['Activo', 'Mantenimiento', 'Baja', 'En Reparación']);
            $table->date('fecha_adquisicion');
            $table->date('fecha_instalacion')->nullable();
            $table->text('descripcion')->nullable(); // antes era observaciones
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipos');
    }
};

