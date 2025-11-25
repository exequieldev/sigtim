<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnostico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diagnosticos';

    protected $fillable = [
        'edificio',
        'piso',
        'oficina',
        'empleado_solicitud',
        'tipo_equipo',
        'marca_equipo',
        'modelo_equipo',
        'porcentaje_funcionalidad',
        'nivel_gravedad',
        'mensaje_diagnostico',
        'analisis_componentes',
        'recomendaciones',
        'componentes_estado',
        'componentes_defectuosos',
        'recursos_necesarios',
        'tecnico_responsable',
        'fecha_diagnostico',
        'estado'
    ];

    protected $casts = [
        'porcentaje_funcionalidad' => 'decimal:2',
        'fecha_diagnostico' => 'date',
        'componentes_estado' => 'array',
        'componentes_defectuosos' => 'array',
        'recursos_necesarios' => 'array',
    ];

    // Constantes para tipos de equipo
    const TIPOS_EQUIPO = [
        'laptop' => 'Laptop/Portátil',
        'desktop' => 'Computadora de Escritorio',
        'impresora' => 'Impresora',
        'monitor' => 'Monitor',
        'router' => 'Router/Access Point',
        'servidor' => 'Servidor',
        'tablet' => 'Tablet',
        'otros' => 'Otros'
    ];

    // Constantes para niveles de gravedad
    const NIVELES_GRAVEDAD = [
        'baja' => 'Baja',
        'media' => 'Media',
        'alta' => 'Alta',
        'critica' => 'Crítica'
    ];

    // Constantes para estados
    const ESTADOS = [
        'pendiente' => 'Pendiente',
        'en_proceso' => 'En Proceso',
        'completado' => 'Completado',
        'cancelado' => 'Cancelado'
    ];

    // Accesores
    public function getTipoEquipoTextoAttribute()
    {
        return self::TIPOS_EQUIPO[$this->tipo_equipo] ?? $this->tipo_equipo;
    }

    public function getNivelGravedadTextoAttribute()
    {
        return self::NIVELES_GRAVEDAD[$this->nivel_gravedad] ?? $this->nivel_gravedad;
    }

    public function getEstadoTextoAttribute()
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getColorGravedadAttribute()
    {
        return match($this->nivel_gravedad) {
            'baja' => 'success',
            'media' => 'warning',
            'alta' => 'danger',
            'critica' => 'dark',
            default => 'secondary'
        };
    }

    public function getColorEstadoAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'warning',
            'en_proceso' => 'info',
            'completado' => 'success',
            'cancelado' => 'secondary',
            default => 'secondary'
        };
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopePorGravedad($query, $gravedad)
    {
        return $query->where('nivel_gravedad', $gravedad);
    }

    public function scopePorTipoEquipo($query, $tipo)
    {
        return $query->where('tipo_equipo', $tipo);
    }
}