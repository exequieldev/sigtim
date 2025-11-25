<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudActividad extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitud_actividad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'solicitud_id',
        'actividad_id',
        'fecha_asignacion',
        'estado_asignacion',
        'observaciones',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_asignacion' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Valores por defecto para los atributos.
     *
     * @var array
     */
    protected $attributes = [
        'estado_asignacion' => 'pendiente',
    ];

    /**
     * Relación con el modelo Solicitud.
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    /**
     * Relación con el modelo Actividad.
     */
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }

    /**
     * Scope para filtrar por estado de asignación.
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado_asignacion', $estado);
    }

    /**
     * Scope para filtrar solicitudes pendientes.
     */
    public function scopePendientes($query)
    {
        return $query->where('estado_asignacion', 'pendiente');
    }

    /**
     * Scope para filtrar solicitudes completadas.
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado_asignacion', 'completado');
    }

    /**
     * Scope para filtrar por actividad específica.
     */
    public function scopePorActividad($query, $actividadId)
    {
        return $query->where('actividad_id', $actividadId);
    }

    /**
     * Scope para filtrar por solicitud específica.
     */
    public function scopePorSolicitud($query, $solicitudId)
    {
        return $query->where('solicitud_id', $solicitudId);
    }

    /**
     * Verificar si la asignación está pendiente.
     */
    public function estaPendiente(): bool
    {
        return $this->estado_asignacion === 'pendiente';
    }

    /**
     * Verificar si la asignación está completada.
     */
    public function estaCompletada(): bool
    {
        return $this->estado_asignacion === 'completado';
    }

    /**
     * Verificar si la asignación está en proceso.
     */
    public function estaEnProceso(): bool
    {
        return $this->estado_asignacion === 'en_proceso';
    }

    /**
     * Marcar la asignación como completada.
     */
    public function marcarComoCompletado(): bool
    {
        return $this->update(['estado_asignacion' => 'completado']);
    }

    /**
     * Marcar la asignación como en proceso.
     */
    public function marcarComoEnProceso(): bool
    {
        return $this->update(['estado_asignacion' => 'en_proceso']);
    }
}