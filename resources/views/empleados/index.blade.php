@extends('layouts.app')

@section('title', 'Empleados')
@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="card-title mr-4">Lista de Empleados</h5>
                <a href="{{ route('empleados.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Nuevo empleado</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped " id="empleados-table">
                        <thead class="table-success">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Oficina</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>{{ $empleado->cargo->nombre}}</td>
                                    <td>{{ $empleado->oficina->nombre }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('empleados.show', $empleado) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar empleado?')"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No hay empleados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">{{ $empleados->links() }}</div>
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
        $('#empleados-table').DataTable({
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