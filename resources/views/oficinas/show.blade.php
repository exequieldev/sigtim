@extends('adminlte::page')

@section('title', 'Detalles de la Oficina')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Detalles de la Oficina</h5>
                <div class="btn-group">
                    <a href="{{ route('oficinas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información General</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Nombre:</th>
                                <td>{{ $oficina->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Departamento:</th>
                                <td>{{ $oficina->departamento->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Total de Empleados:</th>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $oficina->empleados_count ?? $oficina->empleados->count() }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Información Adicional</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Fecha de Creación:</th>
                                <td>{{ $oficina->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Última Actualización:</th>
                                <td>{{ $oficina->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                        
                        <h6 class="mt-3">Descripción</h6>
                        <p class="text-muted">
                            {{ $oficina->descripcion ?: 'Sin descripción' }}
                        </p>
                    </div>
                </div>

                <!-- Empleados Asociados -->
                @if($oficina->empleados && $oficina->empleados->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Empleados Asociados</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Posición</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($oficina->empleados as $empleado)
                                        <tr>
                                            <td>{{ $empleado->nombre ?? 'N/A' }}</td>
                                            <td>{{ $empleado->email ?: 'N/A' }}</td>
                                            <td>{{ $empleado->telefono ?: 'N/A' }}</td>
                                            <td>{{ $empleado->posicion ?: 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Esta oficina no tiene empleados asociados.
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
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
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .badge {
        font-size: 0.75em;
    }
</style>
@endpush