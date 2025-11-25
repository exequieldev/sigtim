@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="card-title mr-4">Lista de Solicitudes</h5>
                <a href="{{ route('solicitudes.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Nueva Solicitud
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="solicitudes-table">
                        <thead class="table-success">
                            <tr>
                                <th>Empleado</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Fecha Inicio</th>
                                <th>Acciones</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($solicitudes as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->empleado->nombre }} {{ $solicitud->empleado->apellido }}</td>
                                    <td>{{ $solicitud->tipoSolicitud->nombre ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($solicitud->estado == 'aprobada') bg-success
                                            @elseif($solicitud->estado == 'pendiente') bg-warning
                                            @elseif($solicitud->estado == 'rechazada') bg-danger
                                            @elseif($solicitud->estado == 'en_proceso') bg-info
                                            @elseif($solicitud->estado == 'completada') bg-primary
                                            @else bg-secondary @endif">
                                            {{ ucfirst($solicitud->estado) }}
                                        </span>
                                    </td>
                                    <td>{{ $solicitud->fecha_inicio->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('solicitudes.show', $solicitud) }}" 
                                               class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('solicitudes.edit', $solicitud) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('solicitudes.destroy', $solicitud) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        title="Eliminar" 
                                                        onclick="return confirm('¿Está seguro de eliminar esta solicitud?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        @if($solicitud->solicitudEquipos->isNotEmpty() && $solicitud->estado == 'pendiente')
                                            <a href="{{ route('diagnosticos.create', ['solicitud_id' => $solicitud->id]) }}" 
                                            class="btn btn-warning btn-sm">
                                                <i class="fas fa-stethoscope"></i> Diagnosticar
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-stethoscope"></i> Diagnosticar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron solicitudes</td>
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

@section('js')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#solicitudes-table').DataTable({
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