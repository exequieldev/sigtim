<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('cuit', 13)->unique();
            $table->string('email')->nullable();
            $table->foreignId('tipo_servicio_id')->constrained('tipo_servicios');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('contacto')->nullable(); // ← AGREGAR
            $table->string('telefono')->nullable(); // ← AGREGAR
            $table->text('direccion')->nullable();  // ← AGREGAR
            $table->timestamps();
            
            $table->index('cuit');
            $table->index('tipo_servicio_id');
            $table->index('estado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
};