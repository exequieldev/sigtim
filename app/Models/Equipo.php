<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = [
        'numero_serie',
        'tipo_equipo_id',
        'fabricante_id',
        'modelo',
        'estado',
        'fecha_adquisicion',
        'fecha_instalacion',
        'descripcion'
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'fecha_instalacion' => 'date',
    ];

    // Relaciones
    public function tipoEquipo()
    {
        return $this->belongsTo(TipoEquipo::class);
    }

    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }

    /**
     * Relación muchos-a-muchos con Componente a través de equipo_componente
     */
    public function componentes()
    {
        return $this->belongsToMany(Componente::class, 'equipo_componente', 'equipo_id', 'componente_id')
                    ->withPivot('activo')
                    ->withTimestamps();
    }

    // ELIMINA esta relación si la tienes:
    // public function componentes()
    // {
    //     return $this->hasMany(Componente::class); // ← Esto causa el error
    // }

    // Scope para búsquedas
    public function scopeBuscar($query, $search)
    {
        return $query->where('numero_serie', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%")
                    ->orWhereHas('fabricante', function($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tipoEquipo', function($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%");
                    });
    }

    // Scope para filtrar por tipo
    public function scopeTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_equipo_id', $tipo);
        }
        return $query;
    }

    // Scope para filtrar por estado
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }
}