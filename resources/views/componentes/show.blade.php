@extends('adminlte::page')

@section('title', 'Detalles del Componente')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Detalles del Componente</h5>
                <div class="btn-group">
                    <a href="{{ route('componentes.index') }}" class="btn btn-secondary btn-sm">
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
                                <th width="40%">ID:</th>
                                <td>{{ $componente->id }}</td>
                            </tr>
                            <tr>
                                <th>Tipo de Componente:</th>
                                <td>
                                    @if($componente->tipoComponente)
                                        <span class="badge bg-primary">{{ $componente->tipoComponente->nombre }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fabricante:</th>
                                <td>{{ $componente->fabricante->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Modelo:</th>
                                <td>{{ $componente->modelo }}</td>
                            </tr>
                            <tr>
                                <th>Número de Serie:</th>
                                <td>
                                    @if($componente->numero_serie)
                                        <code>{{ $componente->numero_serie }}</code>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Información de Fechas</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Fecha de Adquisición:</th>
                                <td>{{ $componente->fecha_adquisicion->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Fecha de Instalación:</th>
                                <td>
                                    @if($componente->fecha_instalacion)
                                        {{ $componente->fecha_instalacion->format('d/m/Y') }}
                                    @else
                                        <span class="badge bg-warning text-dark">No instalado</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fecha de Creación:</th>
                                <td>{{ $componente->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Última Actualización:</th>
                                <td>{{ $componente->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>

                        <!-- Estado del Componente -->
                        <h6 class="mt-3">Estado</h6>
                        <div class="d-flex align-items-center">
                            @if($componente->fecha_instalacion)
                                <span class="badge bg-success me-2">
                                    <i class="fas fa-check-circle"></i> Instalado
                                </span>
                                <small class="text-muted">Instalado el {{ $componente->fecha_instalacion->format('d/m/Y') }}</small>
                            @else
                                <span class="badge bg-secondary me-2">
                                    <i class="fas fa-box"></i> En Inventario
                                </span>
                                <small class="text-muted">Disponible para instalación</small>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Especificaciones Técnicas -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Especificaciones Técnicas</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                @if($componente->especificaciones)
                                    <p class="mb-0">{{ $componente->especificaciones }}</p>
                                @else
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-info-circle"></i> No se han especificado detalles técnicos para este componente.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipos Asociados (si decides agregar esta relación después) -->
                {{--
                @if($componente->equipos && $componente->equipos->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Equipos Asociados</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Modelo del Equipo</th>
                                        <th>Número de Serie</th>
                                        <th>Ubicación</th>
                                        <th>Fecha de Instalación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($componente->equipos as $equipo)
                                        <tr>
                                            <td>
                                                <a href="{{ route('equipos.show', $equipo) }}">
                                                    {{ $equipo->modelo ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ $equipo->numero_serie ?? 'N/A' }}</td>
                                            <td>{{ $equipo->ubicacion ?: 'N/A' }}</td>
                                            <td>
                                                @if($equipo->pivot->fecha_instalacion)
                                                    {{ \Carbon\Carbon::parse($equipo->pivot->fecha_instalacion)->format('d/m/Y') }}
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
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Este componente no está asociado a ningún equipo actualmente.
                        </div>
                    </div>
                </div>
                @endif
                --}}

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
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-family: 'Courier New', monospace;
    }
</style>
@endpush