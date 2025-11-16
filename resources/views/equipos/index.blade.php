@extends('adminlte::page')

@section('title', 'Lista de Equipos')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Inventario de Equipos Informáticos</h5>
                <a href="{{ route('equipos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Equipo
                </a>
            </div>
        </div>
        
        <div class="card">
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped " id="equipos-table">
                        <thead class="table-dark">
                            <tr>
                                <th>N° Serie</th>
                                <th>Tipo</th>
                                <th>Fabricante</th>
                                <th>Modelo</th>
                                <th>Fecha Adquisición</th>
                                <th>Fecha Instalación</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($equipos as $equipo)
                                <tr>
                                    <td>{{ $equipo->numero_serie }}</td>
                                    <td>{{ $equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ $equipo->fabricante->nombre ?? 'N/A' }}</strong><br>
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
                                        <div class="btn-group btn-group-sm">
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
                                    <td colspan="7" class="text-center">No se encontraron equipos</td>
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
<script>
    $(document).ready(function() {
        $('#equipos-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
        });
    });
</script>
@stop