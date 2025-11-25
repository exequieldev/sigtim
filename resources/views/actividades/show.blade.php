@extends('layouts.app')

@section('title', 'Detalles de la Actividad')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Detalles de la Actividad</h5>
                <div class="btn-group">
                    <a href="{{ route('actividades.edit', $actividade) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('actividades.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2 mb-3">Información General</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%" class="text-muted">Nombre:</th>
                                <td>
                                    <span class="fw-bold text-primary">{{ $actividade->nombre }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Programas Asociados:</th>
                                <td>
                                    @if($actividade->programas->count() > 0)
                                        <span class="badge bg-primary rounded-pill">{{ $actividade->programas->count() }}</span>
                                        programas asociados
                                    @else
                                        <span class="text-muted fst-italic">Sin programas asociados</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tipos de Equipo:</th>
                                <td>
                                    @if($actividade->tiposEquipo->count() > 0)
                                        <span class="badge bg-info rounded-pill">{{ $actividade->tiposEquipo->count() }}</span>
                                        tipos de equipo asociados
                                    @else
                                        <span class="text-muted fst-italic">Sin tipos de equipo asociados</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2 mb-3">Información Adicional</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%" class="text-muted">Fecha de Creación:</th>
                                <td>
                                    <i class="fas fa-calendar-plus text-success me-1"></i>
                                    {{ $actividade->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Última Actualización:</th>
                                <td>
                                    <i class="fas fa-calendar-check text-warning me-1"></i>
                                    {{ $actividade->updated_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        </table>
                        
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Descripción</h6>
                        <div class="bg-light rounded p-3">
                            @if($actividade->descripcion)
                                <p class="mb-0">{{ $actividade->descripcion }}</p>
                            @else
                                <p class="mb-0 text-muted fst-italic">
                                    <i class="fas fa-info-circle me-1"></i>Sin descripción
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Programas Asociados -->
                @if($actividade->programas->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-laptop-code text-primary me-2"></i>
                                Programas Asociados
                                <span class="badge bg-primary rounded-pill ms-2">{{ $actividade->programas->count() }}</span>
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">Nombre</th>
                                        <th width="15%">Versión</th>
                                        <th width="20%">Fabricante</th>
                                        <th width="20%">Sistema Operativo</th>
                                        <th width="20%">Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actividade->programas as $programa)
                                        <tr>
                                            <td>
                                                <strong>{{ $programa->nombre }}</strong>
                                            </td>
                                            <td>
                                                @if($programa->version)
                                                    <span class="badge bg-secondary">v{{ $programa->version }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($programa->fabricante)
                                                    <span class="text-primary">{{ $programa->fabricante->nombre }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($programa->sistema_operativo)
                                                    <span class="badge bg-success">{{ $programa->sistema_operativo }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($programa->tipo)
                                                    <span class="badge bg-info">{{ $programa->tipo }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
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
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Sin Programas Asociados</h6>
                                    <p class="mb-0">Esta actividad no tiene programas asociados. Puede editarla para agregar programas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tipos de Equipo Asociados -->
                @if($actividade->tiposEquipo->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-desktop text-info me-2"></i>
                                Tipos de Equipo Asociados
                                <span class="badge bg-info rounded-pill ms-2">{{ $actividade->tiposEquipo->count() }}</span>
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="30%">Nombre</th>
                                        <th width="70%">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actividade->tiposEquipo as $tipoEquipo)
                                        <tr>
                                            <td>
                                                <strong class="text-info">{{ $tipoEquipo->nombre }}</strong>
                                            </td>
                                            <td>
                                                @if($tipoEquipo->descripcion)
                                                    <p class="mb-0">{{ $tipoEquipo->descripcion }}</p>
                                                @else
                                                    <span class="text-muted fst-italic">Sin descripción</span>
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
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Sin Tipos de Equipo Asociados</h6>
                                    <p class="mb-0">Esta actividad no tiene tipos de equipo asociados. Puede editarla para agregar tipos de equipo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            
            <!-- Card Footer -->
            <div class="card-footer bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-id-badge me-1"></i>
                            ID: {{ $actividade->id }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-sync-alt me-1"></i>
                            Actualizado hace {{ $actividade->updated_at->diffForHumans() }}
                        </small>
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
        font-weight: 600;
        color: #495057;
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
    }
    .table-borderless th,
    .table-borderless td {
        border: none !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.025);
    }
    .border-bottom {
        border-color: #dee2e6 !important;
    }
    .fst-italic {
        font-style: italic;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Agregar tooltips si es necesario
        $('[data-toggle="tooltip"]').tooltip();
        
        // Resaltar filas al pasar el mouse
        $('.table-hover tbody tr').hover(
            function() {
                $(this).addClass('table-active');
            },
            function() {
                $(this).removeClass('table-active');
            }
        );
    });
</script>
@endpush