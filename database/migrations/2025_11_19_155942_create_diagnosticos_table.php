<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id();
            
            // Información de la solicitud
            $table->string('edificio');
            $table->string('piso');
            $table->string('oficina');
            $table->string('empleado_solicitud');
            
            // Información del equipo
            $table->enum('tipo_equipo', [
                'laptop', 'desktop', 'impresora', 'monitor', 
                'router', 'servidor', 'tablet', 'otros'
            ]);
            $table->string('marca_equipo')->nullable();
            $table->string('modelo_equipo')->nullable();
            
            // Diagnóstico automático
            $table->decimal('porcentaje_funcionalidad', 5, 2);
            $table->enum('nivel_gravedad', ['baja', 'media', 'alta', 'critica']);
            $table->text('mensaje_diagnostico');
            $table->text('analisis_componentes');
            $table->text('recomendaciones');
            
            // Componentes y estado (almacenado como JSON)
            $table->json('componentes_estado');
            $table->json('componentes_defectuosos');
            $table->json('recursos_necesarios');
            
            // Información del técnico
            $table->string('tecnico_responsable');
            $table->date('fecha_diagnostico');
            
            // Estado del diagnóstico
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado'])->default('pendiente');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejor rendimiento
            $table->index('tipo_equipo');
            $table->index('nivel_gravedad');
            $table->index('estado');
            $table->index('fecha_diagnostico');
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnosticos');
    }
};