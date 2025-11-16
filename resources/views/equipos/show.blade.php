@extends('adminlte::page')

@section('title', 'Detalles del Equipo')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mr-4">Detalles del Equipo Informático</h5>
                <div class="btn-group">
                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">
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
                                <th width="40%">Número de Serie:</th>
                                <td>{{ $equipo->numero_serie }}</td>
                            </tr>
                            <tr>
                                <th>Tipo de Equipo:</th>
                                <td>{{ $equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Fabricante:</th>
                                <td>{{ $equipo->fabricante->nombre ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Modelo:</th>
                                <td>{{ $equipo->modelo }}</td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>
                                    <span class="badge 
                                        @if($equipo->estado == 'Activo') bg-success
                                        @elseif($equipo->estado == 'Mantenimiento') bg-warning
                                        @elseif($equipo->estado == 'Baja') bg-danger
                                        @else bg-secondary @endif">
                                        {{ $equipo->estado }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Información de Fechas</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Fecha de Adquisición:</th>
                                <td>{{ $equipo->fecha_adquisicion->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Fecha de Instalación:</th>
                                <td>{{ $equipo->fecha_instalacion ? $equipo->fecha_instalacion->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                        </table>
                        
                        <h6 class="mt-3">Descripción</h6>
                        <p class="text-muted">
                            {{ $equipo->descripcion ?: 'Sin descripción' }}
                        </p>
                    </div>
                </div>

                <!-- Componentes Asociados -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Componentes Asociados</h6>
                        @if($equipo->componentes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Fabricante</th>
                                            <th>Modelo</th>
                                            <th>N° Serie</th>
                                            <th>Estado</th>
                                            <th>Fecha Instalación</th>
                                            <th>Especificaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($equipo->componentes as $componente)
                                            <tr>
                                                <td>{{ $componente->tipoComponente->nombre ?? 'N/A' }}</td>
                                                <td>{{ $componente->fabricante->nombre ?? 'N/A' }}</td>
                                                <td>{{ $componente->modelo }}</td>
                                                <td>{{ $componente->numero_serie ?: 'N/A' }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($componente->estado == 'Activo') bg-success
                                                        @elseif($componente->estado == 'Mantenimiento') bg-warning
                                                        @elseif($componente->estado == 'Baja') bg-danger
                                                        @else bg-secondary @endif">
                                                        {{ $componente->estado }}
                                                    </span>
                                                </td>
                                                <td>{{ $componente->fecha_instalacion ? $componente->fecha_instalacion->format('d/m/Y') : 'N/A' }}</td>
                                                <td>{{ $componente->especificaciones ?: 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No hay componentes asociados a este equipo.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection