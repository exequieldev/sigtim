<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre de la unidad (GHz, GB, TB, etc.)
            $table->string('simbolo'); // Símbolo (GHz, GB, TB, etc.)
            $table->text('descripcion')->nullable(); // Descripción del uso
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidades');
    }
};