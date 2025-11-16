@extends('adminlte::page')

@section('title', 'Detalles del Programa')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Detalles del Programa</h5>
                <div class="btn-group">
                    <a href="{{ route('programas.index') }}" class="btn btn-secondary btn-sm">
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
                                <td>{{ $programa->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Fabricante:</th>
                                <td>{{ $programa->fabricante->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Versión:</th>
                                <td>{{ $programa->version ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Sistema Operativo:</th>
                                <td>
                                    @if($programa->sistema_operativo)
                                        <span class="badge bg-primary">{{ $programa->sistema_operativo }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Información Adicional</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Fecha de Creación:</th>
                                <td>{{ $programa->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Última Actualización:</th>
                                <td>{{ $programa->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                        
                        <h6 class="mt-3">Descripción</h6>
                        <p class="text-muted">
                            {{ $programa->descripcion ?: 'Sin descripción' }}
                        </p>
                    </div>
                </div>

                <!-- Actividades Asociadas -->
                @if($programa->actividades && $programa->actividades->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Actividades Asociadas</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programa->actividades as $actividad)
                                        <tr>
                                            <td>{{ $actividad->nombre ?? 'N/A' }}</td>
                                            <td>{{ $actividad->descripcion ?: 'N/A' }}</td>
                                            <td>{{ $actividad->fecha ? $actividad->fecha->format('d/m/Y') : 'N/A' }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($actividad->estado == 'Completada') bg-success
                                                    @elseif($actividad->estado == 'En Progreso') bg-warning
                                                    @elseif($actividad->estado == 'Pendiente') bg-info
                                                    @else bg-secondary @endif">
                                                    {{ $actividad->estado ?? 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Requisitos del Sistema -->
                @if($programa->requisitos && $programa->requisitos->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Requisitos del Sistema</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipo de Componente</th>
                                        <th>Requisito Mínimo</th>
                                        <th>Requisito Recomendado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programa->requisitos as $requisito)
                                        <tr>
                                            <td>
                                                <strong>{{ $requisito->tipoComponente->nombre ?? 'N/A' }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Mínimo</span>
                                                {{ $requisito->requisito_minimo }}
                                            </td>
                                            <td>
                                                @if($requisito->requisito_recomendado)
                                                    <span class="badge bg-success">Recomendado</span>
                                                    {{ $requisito->requisito_recomendado }}
                                                @else
                                                    <span class="text-muted">No especificado</span>
                                                @endif
                                            </td>
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
                            <i class="fas fa-info-circle"></i> Este programa no tiene requisitos del sistema especificados.
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