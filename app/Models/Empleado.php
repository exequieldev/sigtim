<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'cargo_id', // Cambiado de 'cargo' a 'cargo_id'
        'oficina_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function oficina()
    {
        return $this->belongsTo(Oficina::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'empleado_equipo')
                    ->using(EmpleadoEquipo::class)
                    ->withPivot('fecha_asignacion', 'observaciones')
                    ->withTimestamps();
    }
}