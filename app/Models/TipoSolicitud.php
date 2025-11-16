<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSolicitud extends Model
{
    use HasFactory;

    protected $table = 'tipo_solicitudes';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con solicitudes
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }
}