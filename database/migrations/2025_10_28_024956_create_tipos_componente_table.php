<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_componente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Procesador, RAM, Almacenamiento, etc.
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_componente');
    }
};