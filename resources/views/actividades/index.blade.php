@extends('layouts.app')

@section('title', 'Lista de Actividades')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i>Catálogo de Actividades
                </h5>
                <a href="{{ route('actividades.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Nueva Actividad
                </a>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="actividades-table">
                        <thead class="table-success">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Descripción</th>
                                <th class="text-center pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($actividades as $actividad)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $actividad->nombre }}</td>
                                    <td>
                                        {{ $actividad->descripcion ?: '<span class="text-muted fst-italic">Sin descripción</span>' }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm justify-content-center">
                                            <a href="{{ route('actividades.show', $actividad) }}" 
                                               class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('actividades.edit', $actividad) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('actividades.destroy', $actividad) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        title="Eliminar" 
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta actividad?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No se encontraron actividades</p>
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
        $('#actividades-table').DataTable({
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