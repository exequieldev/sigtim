<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('componentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_componente_id')->constrained('tipos_componente');
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->string('modelo');
            $table->string('especificaciones')->nullable();
            $table->string('numero_serie')->nullable();
            $table->date('fecha_adquisicion');
            $table->date('fecha_instalacion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('componentes');
    }
};

