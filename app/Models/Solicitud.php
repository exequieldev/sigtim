<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'empleado_id',
        'tipo_solicitud_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con empleado
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    /**
     * Relación con tipo de solicitud
     */
    public function tipoSolicitud(): BelongsTo
    {
        return $this->belongsTo(TipoSolicitud::class, 'tipo_solicitud_id');
    }

    /**
     * Relación con SolicitudActividad (tabla pivote)
     */
    public function solicitudActividades(): HasMany
    {
        return $this->hasMany(SolicitudActividad::class);
    }

    /**
     * Relación con SolicitudEquipo (tabla pivote)
     */
    public function solicitudEquipos(): HasMany
    {
        return $this->hasMany(SolicitudEquipo::class);
    }

    /**
     * Relación con actividades a través de SolicitudActividad
     */
    public function actividades(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class, 'solicitud_actividad')
                    ->using(SolicitudActividad::class)
                    ->withPivot('fecha_asignacion', 'estado_asignacion', 'observaciones')
                    ->withTimestamps();
    }

    /**
     * Relación con equipos a través de SolicitudEquipo
     */
    public function equipos(): BelongsToMany
    {
        return $this->belongsToMany(Equipo::class, 'solicitud_equipo')
                    ->using(SolicitudEquipo::class)
                    ->withPivot('descripcion_uso', 'cantidad', 'fecha_asignacion', 'estado_asignacion', 'observaciones')
                    ->withTimestamps();
    }

    /**
     * Relación con diagnósticos
     */
    public function diagnosticos(): HasMany
    {
        return $this->hasMany(Diagnostico::class);
    }

    /**
     * Verificar si la solicitud es de reparación
     */
    public function esReparacion(): bool
    {
        return $this->tipoSolicitud && stripos($this->tipoSolicitud->nombre, 'reparación') !== false;
    }

    /**
     * Verificar si la solicitud es de adquisición
     */
    public function esAdquisicion(): bool
    {
        return $this->tipoSolicitud && stripos($this->tipoSolicitud->nombre, 'adquisición') !== false;
    }

    /**
     * Verificar si la solicitud tiene diagnóstico
     */
    public function tieneDiagnostico(): bool
    {
        return $this->diagnosticos()->exists();
    }

    /**
     * Verificar si la solicitud tiene actividades
     */
    public function tieneActividades(): bool
    {
        return $this->solicitudActividades()->exists();
    }

    /**
     * Verificar si la solicitud tiene equipos
     */
    public function tieneEquipos(): bool
    {
        return $this->solicitudEquipos()->exists();
    }

    /**
     * Obtener el primer diagnóstico asociado
     */
    public function primerDiagnostico()
    {
        return $this->diagnosticos()->first();
    }

    /**
     * Obtener el primer equipo asociado
     */
    public function primerEquipo()
    {
        return $this->solicitudEquipos()->first();
    }

    /**
     * Scope para solicitudes de reparación
     */
    public function scopeReparacion($query)
    {
        return $query->whereHas('tipoSolicitud', function($q) {
            $q->where('nombre', 'like', '%reparación%');
        });
    }

    /**
     * Scope para solicitudes de adquisición
     */
    public function scopeAdquisicion($query)
    {
        return $query->whereHas('tipoSolicitud', function($q) {
            $q->where('nombre', 'like', '%adquisición%');
        });
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para solicitudes en proceso
     */
    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    /**
     * Scope para solicitudes completadas
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    /**
     * Scope para solicitudes canceladas
     */
    public function scopeCanceladas($query)
    {
        return $query->where('estado', 'cancelada');
    }

    /**
     * Marcar como completada
     */
    public function marcarComoCompletada(): bool
    {
        return $this->update([
            'estado' => 'completada',
            'fecha_fin' => now()
        ]);
    }

    /**
     * Marcar como en proceso
     */
    public function marcarComoEnProceso(): bool
    {
        return $this->update([
            'estado' => 'en_proceso'
        ]);
    }

    /**
     * Marcar como cancelada
     */
    public function marcarComoCancelada(): bool
    {
        return $this->update([
            'estado' => 'cancelada',
            'fecha_fin' => now()
        ]);
    }
}