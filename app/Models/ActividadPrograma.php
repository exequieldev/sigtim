<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ActividadPrograma extends Pivot
{
    use HasFactory;

    protected $table = 'actividad_programa';

    protected $fillable = [
        'actividad_id',
        'programa_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con Actividad
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    // Relación con Programa
    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }
}