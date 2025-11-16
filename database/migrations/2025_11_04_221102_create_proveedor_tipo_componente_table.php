<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proveedor_tipo_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('tipo_componente_id')->constrained('tipos_componente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedor_tipo_componente');
    }
};