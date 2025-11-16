<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       
        Schema::create('proveedor_fabricante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedor_fabricante');
    }
};