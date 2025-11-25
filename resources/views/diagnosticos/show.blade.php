@extends('layouts.app')

@section('title', 'Diagnóstico #' . $diagnostico->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Diagnóstico #{{ $diagnostico->id }}</h5>
                        <div>
                            <span class="badge bg-{{ $diagnostico->color_estado }} fs-6">
                                {{ $diagnostico->estado_texto }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información de la solicitud -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">📝 Información de la Solicitud</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Edificio:</strong><br>
                                    {{ $diagnostico->edificio }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Piso:</strong><br>
                                    {{ $diagnostico->piso }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Oficina:</strong><br>
                                    {{ $diagnostico->oficina }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Empleado:</strong><br>
                                    {{ $diagnostico->empleado_solicitud }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del equipo -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">📋 Información del Equipo</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Tipo de Equipo:</strong><br>
                                    {{ $diagnostico->tipo_equipo_texto }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Marca:</strong><br>
                                    {{ $diagnostico->marca_equipo ?? 'N/A' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Modelo:</strong><br>
                                    {{ $diagnostico->modelo_equipo ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnóstico -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">🔍 Diagnóstico</h6>
                            <div class="card bg-{{ $diagnostico->color_gravedad }} text-white mb-3">
                                <div class="card-body text-center">
                                    <div class="display-4 fw-bold">{{ number_format($diagnostico->porcentaje_funcionalidad, 1) }}%</div>
                                    <div class="h5">{{ $diagnostico->mensaje_diagnostico }}</div>
                                    <div class="progress bg-white bg-opacity-25 mt-3" style="height: 20px;">
                                        <div class="progress-bar bg-white" style="width: {{ $diagnostico->porcentaje_funcionalidad }}%"></div>
                                    </div>
                                    <div class="mt-2">Gravedad: {{ $diagnostico->nivel_gravedad_texto }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Componentes -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">🔧 Estado de Componentes</h6>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Componente</th>
                                            <th>Estado</th>
                                            <th>Importancia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($diagnostico->componentes_estado as $componente)
                                            <tr>
                                                <td>
                                                    {{ $componente['nombre'] }}
                                                    @if($componente['critico'] ?? false)
                                                        <span class="badge bg-warning">⭐ Crítico</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $estadoClass = match($componente['estado']) {
                                                            'good' => 'success',
                                                            'faulty' => 'danger',
                                                            default => 'warning'
                                                        };
                                                        $estadoText = match($componente['estado']) {
                                                            'good' => 'Buen Estado',
                                                            'faulty' => 'Defectuoso',
                                                            default => 'Por Verificar'
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $estadoClass }}">{{ $estadoText }}</span>
                                                </td>
                                                <td>{{ $componente['peso'] ?? 0 }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Análisis y Recomendaciones -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Análisis de Componentes</h6>
                                </div>
                                <div class="card-body">
                                    {!! nl2br(e($diagnostico->analisis_componentes)) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Recomendaciones</h6>
                                </div>
                                <div class="card-body">
                                    {!! nl2br(e($diagnostico->recomendaciones)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Información del técnico -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">👨‍💼 Información del Técnico</h6>
                </div>
                <div class="card-body">
                    <p><strong>Técnico Responsable:</strong><br>
                    {{ $diagnostico->tecnico_responsable }}</p>
                    
                    <p><strong>Fecha del Diagnóstico:</strong><br>
                    {{ $diagnostico->fecha_diagnostico->format('d/m/Y') }}</p>
                    
                    <p><strong>Creado:</strong><br>
                    {{ $diagnostico->created_at->format('d/m/Y H:i') }}</p>
                    
                    @if($diagnostico->updated_at != $diagnostico->created_at)
                        <p><strong>Última Actualización:</strong><br>
                        {{ $diagnostico->updated_at->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Recursos necesarios -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">🛠️ Recursos para Reparación</h6>
                </div>
                <div class="card-body">
                    @if(!empty($diagnostico->recursos_necesarios) && count($diagnostico->recursos_necesarios) > 0)
                        <div class="list-group">
                            @foreach($diagnostico->recursos_necesarios as $recurso)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $recurso['nombre'] }}
                                    <span class="badge bg-primary rounded-pill">{{ $recurso['cantidad'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No se requieren recursos adicionales.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('diagnosticos.edit', $diagnostico) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Diagnóstico
                        </a>
                        <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                        <form action="{{ route('diagnosticos.destroy', $diagnostico) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('¿Está seguro de eliminar este diagnóstico?')">
                                <i class="fas fa-trash"></i> Eliminar Diagnóstico
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection