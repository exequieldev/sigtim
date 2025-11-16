<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComponente extends Model
{
    use HasFactory;

    protected $table = 'tipos_componente';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Relaciones
    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function proveedores(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, 'proveedor_tipo_componente')
                    ->withTimestamps();
    }
}