<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudDiagnostico extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitud_diagnostico';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'solicitud_id',
        'diagnostico_id',
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
        'deleted_at' => 'datetime',
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
     * Relación con el modelo Diagnostico.
     */
    public function diagnostico(): BelongsTo
    {
        return $this->belongsTo(Diagnostico::class);
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