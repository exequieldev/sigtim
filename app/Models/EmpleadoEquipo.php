<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmpleadoEquipo extends Pivot
{
    protected $table = 'empleado_equipo';

    protected $fillable = [
        'empleado_id',
        'equipo_id',
        'fecha_asignacion',
        'observaciones'
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    // Relación con Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}