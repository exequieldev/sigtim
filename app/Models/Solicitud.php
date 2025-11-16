<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'fecha_inicio',
        'estado',
        'empleado_id',
        'tipo_solicitud_id'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con empleado
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    /**
     * Relación con tipo de solicitud
     */
    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitud::class, 'tipo_solicitud_id');
    }

    /**
     * Relación muchos a muchos con actividades
     */
    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'solicitud_actividad');
    }
}