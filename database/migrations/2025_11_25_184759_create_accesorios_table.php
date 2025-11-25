<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('accesorios', function (Blueprint $table) {
            $table->id();
            $table->string('numero_serie')->unique();
            $table->foreignId('tipo_accesorio_id')->constrained('tipos_accesorio');
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->string('modelo');
            $table->enum('estado', ['Activo', 'Mantenimiento', 'Baja', 'En Reparación', 'Disponible', 'Asignado']);
            $table->date('fecha_adquisicion');
            $table->date('fecha_instalacion')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accesorios');
    }
};