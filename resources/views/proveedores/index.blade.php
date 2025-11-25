@extends('layouts.app')

@section('title', 'Lista de Proveedores')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="card-title mr-4">Lista de Proveedores</h5>
                <a href="{{ route('proveedores.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Proveedor
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="table table-striped" id="proveedor-table">
                        <thead class="table-success">
                            <tr>
                                <th>Razón Social</th>
                                <th>CUIT</th>
                                <th>Email</th>
                                <th>Tipo Servicio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proveedores as $proveedor)
                                <tr>
                                    <td>{{ $proveedor->razon_social }}</td>
                                    <td>{{ $proveedor->cuit ?: 'N/A' }}</td>
                                    <td>{{ $proveedor->email ?: 'N/A' }}</td>
                                    <td>{{ $proveedor->tipoServicio->nombre ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $proveedor->estado == 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($proveedor->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('proveedores.show', $proveedor) }}" 
                                               class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('proveedores.edit', $proveedor) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('proveedores.destroy', $proveedor) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        title="Eliminar" 
                                                        onclick="return confirm('¿Está seguro de eliminar este proveedor?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron proveedores</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $proveedores->links() }}
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
        $('#proveedor-table').DataTable({
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