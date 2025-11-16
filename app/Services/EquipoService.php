<?php

namespace App\Services;

use App\Models\Equipo;
use Illuminate\Support\Facades\DB;

class EquipoService
{
    public function crearEquipo(array $data): Equipo
    {
        return DB::transaction(function () use ($data) {
            return Equipo::create($data);
        });
    }

    public function actualizarEquipo(Equipo $equipo, array $data): bool
    {
        return DB::transaction(function () use ($equipo, $data) {
            return $equipo->update($data);
        });
    }

    public function eliminarEquipo(Equipo $equipo): bool
    {
        return DB::transaction(function () use ($equipo) {
            return $equipo->delete();
        });
    }

    public function obtenerEstadisticas(): array
    {
        return [
            'total_equipos' => Equipo::count(),
            'equipos_activos' => Equipo::where('estado', 'Activo')->count(),
            'equipos_mantenimiento' => Equipo::where('estado', 'Mantenimiento')->count(),
            'equipos_baja' => Equipo::where('estado', 'Baja')->count(),
            'por_tipo' => Equipo::with('tipoEquipo')
                ->get()
                ->groupBy('tipoEquipo.nombre')
                ->map->count()
                ->toArray(),
        ];
    }

    public function generarReporte(array $filtros = []): array
    {
        $query = Equipo::query();

        if (isset($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (isset($filtros['fecha_desde'])) {
            $query->where('fecha_adquisicion', '>=', $filtros['fecha_desde']);
        }

        if (isset($filtros['fecha_hasta'])) {
            $query->where('fecha_adquisicion', '<=', $filtros['fecha_hasta']);
        }

        if (isset($filtros['tipo_equipo_id'])) {
            $query->where('tipo_equipo_id', $filtros['tipo_equipo_id']);
        }

        return $query->get()->toArray();
    }
}