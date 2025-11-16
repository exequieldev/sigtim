@extends('adminlte::page')

@section('title', 'Lista de Componentes')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Inventario de Componentes</h5>
                <a href="{{ route('componentes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Componente
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="componentes-table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tipo Componente</th>
                                <th>Fabricante</th>
                                <th>Modelo</th>
                                <th>N° Serie</th>
                                <th>Fecha Adquisición</th>
                                <th>Fecha Instalación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($componentes as $componente)
                                <tr>
                                    <td>{{ $componente->id }}</td>
                                    <td>{{ $componente->tipoComponente->nombre ?? 'N/A' }}</td>
                                    <td>{{ $componente->fabricante->nombre ?? 'N/A' }}</td>
                                    <td>{{ $componente->modelo }}</td>
                                    <td>{{ $componente->numero_serie ?? 'N/A' }}</td>
                                    <td>{{ $componente->fecha_adquisicion->format('d/m/Y') }}</td>
                                    <td>{{ $componente->fecha_instalacion ? $componente->fecha_instalacion->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('componentes.show', $componente) }}" 
                                               class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('componentes.edit', $componente) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('componentes.destroy', $componente) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        title="Eliminar" 
                                                       >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No se encontraron componentes</td>
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
        $('#componentes-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "order": [[0, 'desc']]
        });
    });
</script>
@stop