<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoComponente extends Model
{
    use HasFactory;

    protected $table = 'equipo_componente';

    protected $fillable = [
        'equipo_id',
        'componente_id',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    /**
     * Relación con el modelo Equipo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    /**
     * Relación con el modelo Componente
     */
    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}