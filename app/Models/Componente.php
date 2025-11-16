<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;

    protected $table = 'componentes';

    protected $fillable = [
        'equipo_id',
        'tipo_componente_id',
        'fabricante_id',
        'modelo',
        'especificaciones',
        'numero_serie',
        'fecha_adquisicion',
        'fecha_instalacion'
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'fecha_instalacion' => 'date',
    ];

    // Relaciones
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function tipoComponente()
    {
        return $this->belongsTo(TipoComponente::class);
    }

    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }
}