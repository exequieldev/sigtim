<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    use HasFactory;

    protected $table = 'tipos_equipo';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Relaciones
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function proveedores(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, 'proveedor_tipo_equipo')
                    ->withTimestamps();
    }
}