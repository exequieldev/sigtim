@extends('adminlte::page')

@section('title', 'Detalles del Proveedor')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Detalles del Proveedor</h5>
                <div class="btn-group">
                    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Información Básica -->
                    <div class="col-md-6">
                        <h6>Información Básica</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Razón Social:</th>
                                <td>{{ $proveedor->razon_social }}</td>
                            </tr>
                            <tr>
                                <th>CUIT:</th>
                                <td>{{ $proveedor->cuit }}</td>
                            </tr>
                            <tr>
                                <th>Tipo de Servicio:</th>
                                <td>
                                    @if($proveedor->tipoServicio)
                                        <span class="badge badge-primary">{{ $proveedor->tipoServicio->nombre }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>
                                    <span class="badge badge-{{ $proveedor->estado == 'activo' ? 'success' : 'danger' }}">
                                        {{ ucfirst($proveedor->estado) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Información de Contacto -->
                    <div class="col-md-6">
                        <h6>Información de Contacto</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Contacto:</th>
                                <td>{{ $proveedor->contacto ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Teléfono:</th>
                                <td>
                                    @if($proveedor->telefono)
                                        <a href="tel:{{ $proveedor->telefono }}" class="text-decoration-none">
                                            {{ $proveedor->telefono }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    @if($proveedor->email)
                                        <a href="mailto:{{ $proveedor->email }}" class="text-decoration-none">
                                            {{ $proveedor->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Dirección</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-0">{{ $proveedor->direccion ?: 'Sin dirección registrada' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tipos de Componente -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6>Tipos de Componente</h6>
                        <div class="card">
                            <div class="card-body">
                                @if($proveedor->tiposComponente && $proveedor->tiposComponente->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($proveedor->tiposComponente as $tipoComponente)
                                            <span class="badge badge-info p-2">
                                                <i class="fas fa-microchip mr-1"></i>{{ $tipoComponente->nombre }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No se han asignado tipos de componente</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tipos de Equipo -->
                    <div class="col-md-6">
                        <h6>Tipos de Equipo</h6>
                        <div class="card">
                            <div class="card-body">
                                @if($proveedor->tiposEquipo && $proveedor->tiposEquipo->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($proveedor->tiposEquipo as $tipoEquipo)
                                            <span class="badge badge-warning p-2">
                                                <i class="fas fa-desktop mr-1"></i>{{ $tipoEquipo->nombre }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No se han asignado tipos de equipo</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Información del Sistema</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="20%">Fecha de Creación:</th>
                                <td>{{ $proveedor->created_at ? $proveedor->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Última Actualización:</th>
                                <td>{{ $proveedor->updated_at ? $proveedor->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

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
        font-size: 0.85em;
    }
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endpush