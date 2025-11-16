<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'version',
        'fabricante_id',
        'sistema_operativo'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con Fabricante
    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }

    // NUEVA RELACIÓN: Relación con ProgramaRequisito
    public function requisitos()
    {
        return $this->hasMany(ProgramaRequisito::class);
    }

    // Scope para búsqueda (mejorado para buscar también en fabricante)
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            return $query->where('nombre', 'LIKE', "%{$search}%")
                        ->orWhere('descripcion', 'LIKE', "%{$search}%")
                        ->orWhere('version', 'LIKE', "%{$search}%")
                        ->orWhere('sistema_operativo', 'LIKE', "%{$search}%")
                        ->orWhereHas('fabricante', function($q) use ($search) {
                            $q->where('nombre', 'LIKE', "%{$search}%");
                        });
        }
        return $query;
    }
}