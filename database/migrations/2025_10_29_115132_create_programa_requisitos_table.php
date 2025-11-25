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
            $table->foreignId('unidad_medida_id')->constrained('unidades'); // Clave foránea
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programa_requisitos');
    }
};