<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    use HasFactory;

    protected $table = 'fabricantes';

    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'email'
    ];

    // Relaciones
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    // Scope para búsquedas
    public function scopeBuscar($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('contacto', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
    }
}