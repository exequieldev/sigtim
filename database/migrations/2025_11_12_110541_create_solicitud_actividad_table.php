<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
  
        Schema::create('solicitud_actividad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes');
            $table->foreignId('actividad_id')->constrained('actividades');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_actividad');
    }
};