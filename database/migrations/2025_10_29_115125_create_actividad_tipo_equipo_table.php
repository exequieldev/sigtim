<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('actividad_tipo_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades');
            $table->foreignId('tipo_equipo_id')->constrained('tipos_equipo');
            $table->timestamps();
        });

        
    }

    public function down()
    {
        Schema::dropIfExists('actividad_tipo_equipo');

    }
};