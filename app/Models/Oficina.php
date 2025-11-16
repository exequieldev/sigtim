<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    use HasFactory;

    protected $table = 'oficinas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'departamento_id'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}