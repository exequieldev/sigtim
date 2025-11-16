@extends('adminlte::page')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Detalles del Empleado</h5>
                <div class="btn-group">
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información Personal</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Nombre:</th>
                                <td>{{ $empleado->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Apellido:</th>
                                <td>{{ $empleado->apellido }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $empleado->email }}</td>
                            </tr>
                            <tr>
                                <th>Teléfono:</th>
                                <td>{{ $empleado->telefono ?: 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Información Laboral</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Cargo:</th>
                                <td>{{ $empleado->cargo }}</td>
                            </tr>
                            <tr>
                                <th>Oficina:</th>
                                <td>
                                    @if($empleado->oficina)
                                        {{ $empleado->oficina->nombre }}
                                        <small class="text-muted">
                                            ({{ $empleado->oficina->departamento->nombre ?? 'Sin departamento' }})
                                        </small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Equipos Asociados -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-laptop mr-2"></i>Equipos Asociados
                    <span class="badge badge-primary ml-2">{{ $empleado->equipos->count() }}</span>
                </h6>
            </div>
            <div class="card-body">
                @if($empleado->equipos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>N° Serie</th>
                                    <th>Tipo</th>
                                    <th>Fabricante</th>
                                    <th>Modelo</th>
                                    <th>Estado</th>
                                    <th>Fecha Asignación</th>
                                    <th>Observaciones</th>
                                    <th width="100px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empleado->equipos as $equipo)
                                    <tr>
                                        <td>
                                            <strong>{{ $equipo->numero_serie }}</strong>
                                        </td>
                                        <td>{{ $equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                                        <td>{{ $equipo->fabricante->nombre ?? 'N/A' }}</td>
                                        <td>{{ $equipo->modelo }}</td>
                                        <td>
                                            @php
                                                $badgeClass = [
                                                    'Activo' => 'badge-success',
                                                    'Mantenimiento' => 'badge-warning',
                                                    'Baja' => 'badge-danger',
                                                    'En Reparación' => 'badge-info'
                                                ][$equipo->estado] ?? 'badge-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $equipo->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $equipo->pivot->fecha_asignacion->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ Str::limit($equipo->pivot->observaciones, 30) ?: 'Sin observaciones' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('equipos.show', $equipo->id) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Ver equipo"
                                                   data-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-laptop fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Este empleado no tiene equipos asignados.</p>

                    </div>
                @endif
            </div>
        </div>

        <!-- Botones de Acción -->
        <!-- <div class="card mt-4">
            <div class="card-body text-center">
                <div class="btn-group">
                    <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Empleado
                    </a>
                    <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger ml-2" 
                                onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
                            <i class="fas fa-trash"></i> Eliminar Empleado
                        </button>
                    </form>
                </div>
            </div>
        </div> -->

    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .badge {
        font-size: 0.75em;
        font-weight: 500;
    }
    .table-responsive {
        border-radius: 0.25rem;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Opcional: Inicializar DataTable si quieres más funcionalidades
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "pageLength": 10,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
        });
    });
</script>
@endpush