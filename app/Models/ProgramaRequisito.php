<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaRequisito extends Model
{
    use HasFactory;

    protected $table = 'programa_requisitos';

    protected $fillable = [
        'programa_id',
        'tipo_componente_id',
        'requisito_minimo',
        'requisito_recomendado',
        'unidad_medida'
    ];

    // Constantes para las unidades de medida
    const UNIDAD_GHZ = 'GHz';
    const UNIDAD_MHZ = 'MHz';
    const UNIDAD_GB = 'GB';
    const UNIDAD_TB = 'TB';
    const UNIDAD_MB = 'MB';
    const UNIDAD_GB_VRAM = 'GB_VRAM';
    const UNIDAD_CORES = 'Cores';
    const UNIDAD_THREADS = 'Threads';
    const UNIDAD_BITS = 'Bits';
    const UNIDAD_WATTS = 'Watts';
    const UNIDAD_RPM = 'RPM';
    const UNIDAD_GB_S = 'GB_s';
    const UNIDAD_UNIDAD = 'Unidad';
    const UNIDAD_NA = 'N/A';

    // Array de todas las unidades disponibles
    public static function getUnidadesMedida()
    {
        return [
            self::UNIDAD_GHZ,
            self::UNIDAD_MHZ,
            self::UNIDAD_GB,
            self::UNIDAD_TB,
            self::UNIDAD_MB,
            self::UNIDAD_GB_VRAM,
            self::UNIDAD_CORES,
            self::UNIDAD_THREADS,
            self::UNIDAD_BITS,
            self::UNIDAD_WATTS,
            self::UNIDAD_RPM,
            self::UNIDAD_GB_S,
            self::UNIDAD_UNIDAD,
            self::UNIDAD_NA,
        ];
    }

    // Relaciones
    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }

    public function tipoComponente()
    {
        return $this->belongsTo(TipoComponente::class, 'tipo_componente_id');
    }

    // Scope para búsquedas
    public function scopeBuscar($query, $search)
    {
        return $query->where('requisito_minimo', 'like', "%{$search}%")
                    ->orWhere('requisito_recomendado', 'like', "%{$search}%")
                    ->orWhere('unidad_medida', 'like', "%{$search}%")
                    ->orWhereHas('programa', function($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tipoComponente', function($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%");
                    });
    }

    // Accesores
    public function getRequisitoCompletoAttribute()
    {
        $completo = "Mínimo: {$this->requisito_minimo} {$this->unidad_medida}";
        
        if ($this->requisito_recomendado) {
            $completo .= " | Recomendado: {$this->requisito_recomendado} {$this->unidad_medida}";
        }
        
        return $completo;
    }

    public function getRequisitoMinimoCompletoAttribute()
    {
        return "{$this->requisito_minimo} {$this->unidad_medida}";
    }

    public function getRequisitoRecomendadoCompletoAttribute()
    {
        if (!$this->requisito_recomendado) {
            return null;
        }
        return "{$this->requisito_recomendado} {$this->unidad_medida}";
    }

    // Método para obtener la unidad de medida formateada
    public function getUnidadMedidaFormateadaAttribute()
    {
        $unidades = [
            self::UNIDAD_GHZ => 'GHz',
            self::UNIDAD_MHZ => 'MHz',
            self::UNIDAD_GB => 'GB',
            self::UNIDAD_TB => 'TB',
            self::UNIDAD_MB => 'MB',
            self::UNIDAD_GB_VRAM => 'GB VRAM',
            self::UNIDAD_CORES => 'Núcleos',
            self::UNIDAD_THREADS => 'Hilos',
            self::UNIDAD_BITS => 'Bits',
            self::UNIDAD_WATTS => 'W',
            self::UNIDAD_RPM => 'RPM',
            self::UNIDAD_GB_S => 'GB/s',
            self::UNIDAD_UNIDAD => 'Unidades',
            self::UNIDAD_NA => 'N/A',
        ];

        return $unidades[$this->unidad_medida] ?? $this->unidad_medida;
    }

    // Mutador para unidad_medida
    public function setUnidadMedidaAttribute($value)
    {
        $this->attributes['unidad_medida'] = in_array($value, self::getUnidadesMedida()) 
            ? $value 
            : self::UNIDAD_UNIDAD;
    }
}