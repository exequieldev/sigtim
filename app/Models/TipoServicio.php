<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    use HasFactory;

    protected $table = 'tipo_servicios';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con proveedores
     */
    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }
}