@extends('layouts.app')

@section('title', 'Lista de Equipos')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-desktop me-2"></i>Inventario de Equipos Informáticos
                </h5>
                <a href="{{ route('equipos.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Nuevo Equipo
                </a>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="equipos-table">
                        <thead class="table-success">
                            <tr>
                                <th class="ps-4">N° Serie</th>
                                <th>Tipo</th>
                                <th>Fabricante</th>
                                <th>Modelo</th>
                                <th>Fecha Adquisición</th>
                                <th>Fecha Instalación</th>
                                <th>Estado</th>
                                <th class="text-center pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($equipos as $equipo)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $equipo->numero_serie }}</td>
                                    <td>{{ $equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ $equipo->fabricante->nombre ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $equipo->modelo }}</td>
                                    <td>{{ $equipo->fecha_adquisicion->format('d/m/Y') }}</td>
                                    <td>{{ $equipo->fecha_instalacion ? $equipo->fecha_instalacion->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($equipo->estado == 'Activo') bg-success
                                            @elseif($equipo->estado == 'Mantenimiento') bg-warning
                                            @elseif($equipo->estado == 'Baja') bg-danger
                                            @else bg-secondary @endif">
                                            {{ $equipo->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm justify-content-center">
                                            <a href="{{ route('equipos.show', $equipo) }}" 
                                               class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('equipos.edit', $equipo) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('equipos.destroy', $equipo) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        title="Eliminar" 
                                                        onclick="return confirm('¿Está seguro de eliminar este equipo?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-desktop fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No se encontraron equipos</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
    
    .btn-group .btn {
        border-radius: 6px;
        margin: 0 2px;
    }
</style>
@endsection

@section('js')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#equipos-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "responsive": true,
            "ordering": true,
            "searching": true,
            "info": true
        });
    });
</script>
@stop