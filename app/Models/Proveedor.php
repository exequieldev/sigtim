<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'razon_social',
        'cuit',
        'email',
        'tipo_servicio_id',
        'estado',
        'contacto',
        'telefono',
        'direccion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el tipo de servicio
     */
    public function tipoServicio(): BelongsTo
    {
        return $this->belongsTo(TipoServicio::class);
    }

    /**
     * Relación muchos a muchos con TipoComponente
     */
    public function tiposComponente(): BelongsToMany
    {
        return $this->belongsToMany(TipoComponente::class, 'proveedor_tipo_componente')
                    ->withTimestamps();
    }

    /**
     * Relación muchos a muchos con TipoEquipo
     */
    public function tiposEquipo(): BelongsToMany
    {
        return $this->belongsToMany(TipoEquipo::class, 'proveedor_tipo_equipo')
                    ->withTimestamps();
    }

    /**
     * Scope para proveedores activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para proveedores inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    /**
     * Verificar si el proveedor está activo
     */
    public function estaActivo()
    {
        return $this->estado === 'activo';
    }

    /**
     * Obtener los IDs de tipos de componente asociados
     */
    public function getTiposComponenteIdsAttribute()
    {
        return $this->tiposComponente->pluck('id')->toArray();
    }

    /**
     * Obtener los IDs de tipos de equipo asociados
     */
    public function getTiposEquipoIdsAttribute()
    {
        return $this->tiposEquipo->pluck('id')->toArray();
    }

    /**
     * Obtener los nombres de tipos de componente como string
     */
    public function getTiposComponenteNombresAttribute()
    {
        return $this->tiposComponente->pluck('nombre')->implode(', ');
    }

    /**
     * Obtener los nombres de tipos de equipo como string
     */
    public function getTiposEquipoNombresAttribute()
    {
        return $this->tiposEquipo->pluck('nombre')->implode(', ');
    }
}