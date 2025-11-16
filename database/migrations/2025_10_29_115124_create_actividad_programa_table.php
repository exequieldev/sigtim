<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('actividad_programa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades');
            $table->foreignId('programa_id')->constrained('programas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actividad_programa');
    }
};