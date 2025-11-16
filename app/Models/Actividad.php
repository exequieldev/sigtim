<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function programas()
    {
        return $this->belongsToMany(Programa::class, 'actividad_programa');
    }

    public function tiposEquipo()
    {
        return $this->belongsToMany(TipoEquipo::class, 'actividad_tipo_equipo');
    }

    public function empleado()
{
    return $this->belongsTo(Empleado::class);
}

    // Scope para búsquedas
    public function scopeBuscar($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
    }
}