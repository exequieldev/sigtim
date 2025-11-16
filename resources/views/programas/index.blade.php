@extends('adminlte::page')

@section('title', 'Lista de Programas')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Catálogo de Programas</h5>
                <a href="{{ route('programas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Programa
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="programas-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Fabricante</th>
                                <th>Versión</th>
                                <th>Sistema Operativo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programas as $programa)
                                <tr>
                                    <td>{{ $programa->nombre }}</td>
                                    <td>
                                        @if($programa->fabricante)
                                            {{ $programa->fabricante->nombre }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $programa->version ?: 'N/A' }}</td>
                                    <td>
                                        @if($programa->sistema_operativo)
                                            <span class="badge bg-primary">{{ $programa->sistema_operativo }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('programas.show', $programa) }}" 
                                               class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('programas.edit', $programa) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('programas.destroy', $programa) }}" 
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
                                    <td colspan="5" class="text-center">No se encontraron programas</td>
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
        $('#programas-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
        });
    });
</script>
@stop