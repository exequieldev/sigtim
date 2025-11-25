<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'nombre',
        'simbolo',
        'descripcion',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the componentes for the unidad.
     */
    public function componentes(): HasMany
    {
        return $this->hasMany(Componente::class, 'unidad_medida_id');
    }

    /**
     * Get the programa requisitos for the unidad.
     */
    public function programaRequisitos(): HasMany
    {
        return $this->hasMany(ProgramaRequisito::class, 'unidad_medida_id');
    }
}