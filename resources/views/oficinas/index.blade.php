@extends('layouts.app')

@section('title', 'Oficinas')
@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="card-title mr-4">Oficinas</h5>
                <a href="{{ route('oficinas.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Nuevas oficina</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="oficinas-table">
                        <thead class="table-success">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Departamento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($oficinas as $oficina)
                                <tr>
                                    <td>{{ $oficina->nombre }}</td>
                                    <td>{{ $oficina->descripcion ?: 'N/A' }}</td>
                                    <td>{{ $oficina->departamento->nombre }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('oficinas.show', $oficina) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('oficinas.edit', $oficina) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('oficinas.destroy', $oficina) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar oficina?')"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No hay oficinas</td></tr>
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
        $('#oficinas-table').DataTable({
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