@extends('layouts.app')

@section('title', 'Diagnósticos de Equipos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Sistema de Diagnóstico Automático</h5>
                        <a href="{{ route('diagnosticos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nuevo Diagnóstico
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Estadísticas
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total</h6>
                                            <h3>{{ $estadisticas['total'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-list fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Pendientes</h6>
                                            <h3>{{ $estadisticas['pendientes'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">En Proceso</h6>
                                            <h3>{{ $estadisticas['en_proceso'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-tools fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Completados</h6>
                                            <h3>{{ $estadisticas['completados'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('diagnosticos.index') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="search" class="form-label">Buscar</label>
                                                <input type="text" class="form-control" id="search" name="search" 
                                                       value="{{ request('search') }}" placeholder="Equipo, técnico, oficina...">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select class="form-select" id="estado" name="estado">
                                                    <option value="">Todos</option>
                                                    @foreach(App\Models\Diagnostico::ESTADOS as $key => $value)
                                                        <option value="{{ $key }}" {{ request('estado') == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tipo_equipo" class="form-label">Tipo Equipo</label>
                                                <select class="form-select" id="tipo_equipo" name="tipo_equipo">
                                                    <option value="">Todos</option>
                                                    @foreach(App\Models\Diagnostico::TIPOS_EQUIPO as $key => $value)
                                                        <option value="{{ $key }}" {{ request('tipo_equipo') == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nivel_gravedad" class="form-label">Gravedad</label>
                                                <select class="form-select" id="nivel_gravedad" name="nivel_gravedad">
                                                    <option value="">Todos</option>
                                                    @foreach(App\Models\Diagnostico::NIVELES_GRAVEDAD as $key => $value)
                                                        <option value="{{ $key }}" {{ request('nivel_gravedad') == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary me-2">
                                                    <i class="fas fa-filter"></i> Filtrar
                                                </button>
                                                <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary">
                                                    <i class="fas fa-redo"></i> Limpiar
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Tabla de diagnósticos -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipo</th>
                                    <th>Ubicación</th>
                                    <th>Funcionalidad</th>
                                    <th>Gravedad</th>
                                    <th>Estado</th>
                                    <th>Técnico</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($diagnosticos as $diagnostico)
                                    <tr>
                                        <td>#{{ $diagnostico->id }}</td>
                                        <td>
                                            <strong>{{ $diagnostico->tipo_equipo_texto }}</strong>
                                            @if($diagnostico->marca_equipo)
                                                <br><small class="text-muted">{{ $diagnostico->marca_equipo }} {{ $diagnostico->modelo_equipo }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $diagnostico->edificio }} - Piso {{ $diagnostico->piso }}<br>
                                            <small class="text-muted">{{ $diagnostico->oficina }}</small>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar 
                                                    @if($diagnostico->porcentaje_funcionalidad >= 80) bg-success
                                                    @elseif($diagnostico->porcentaje_funcionalidad >= 50) bg-warning
                                                    @elseif($diagnostico->porcentaje_funcionalidad >= 20) bg-danger
                                                    @else bg-dark @endif" 
                                                    role="progressbar" 
                                                    style="width: {{ $diagnostico->porcentaje_funcionalidad }}%"
                                                    aria-valuenow="{{ $diagnostico->porcentaje_funcionalidad }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                    {{ number_format($diagnostico->porcentaje_funcionalidad, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $diagnostico->color_gravedad }}">
                                                {{ $diagnostico->nivel_gravedad_texto }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $diagnostico->color_estado }}">
                                                {{ $diagnostico->estado_texto }}
                                            </span>
                                        </td>
                                        <td>{{ $diagnostico->tecnico_responsable }}</td>
                                        <td>{{ $diagnostico->fecha_diagnostico->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('diagnosticos.show', $diagnostico) }}" 
                                                   class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('diagnosticos.edit', $diagnostico) }}" 
                                                   class="btn btn-warning btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('diagnosticos.destroy', $diagnostico) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            title="Eliminar" 
                                                            onclick="return confirm('¿Está seguro de eliminar este diagnóstico?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> No se encontraron diagnósticos.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Mostrando {{ $diagnosticos->firstItem() ?? 0 }} - {{ $diagnosticos->lastItem() ?? 0 }} 
                            de {{ $diagnosticos->total() }} registros
                        </div>
                        {{ $diagnosticos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 0.375rem;
    }
    .progress-bar {
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush