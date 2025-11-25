@extends('layouts.app')

@section('title', 'Editar Diagnóstico #' . $diagnostico->id)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Editar Diagnóstico #{{ $diagnostico->id }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('diagnosticos.update', $diagnostico) }}" method="POST" id="diagnosticoForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información de la solicitud -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">📝 Información de la Solicitud</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edificio" class="form-label">Edificio *</label>
                                            <input type="text" class="form-control @error('edificio') is-invalid @enderror" 
                                                   id="edificio" name="edificio" 
                                                   value="{{ old('edificio', $diagnostico->edificio) }}" required>
                                            @error('edificio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="piso" class="form-label">Piso *</label>
                                            <input type="text" class="form-control @error('piso') is-invalid @enderror" 
                                                   id="piso" name="piso" 
                                                   value="{{ old('piso', $diagnostico->piso) }}" required>
                                            @error('piso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="oficina" class="form-label">Oficina *</label>
                                            <input type="text" class="form-control @error('oficina') is-invalid @enderror" 
                                                   id="oficina" name="oficina" 
                                                   value="{{ old('oficina', $diagnostico->oficina) }}" required>
                                            @error('oficina')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="empleado_solicitud" class="form-label">Empleado que realizó la solicitud *</label>
                                            <input type="text" class="form-control @error('empleado_solicitud') is-invalid @enderror" 
                                                   id="empleado_solicitud" name="empleado_solicitud" 
                                                   value="{{ old('empleado_solicitud', $diagnostico->empleado_solicitud) }}" required>
                                            @error('empleado_solicitud')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del equipo -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">📋 Información del Equipo</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tipo_equipo" class="form-label">Tipo de Equipo *</label>
                                            <select class="form-select @error('tipo_equipo') is-invalid @enderror" 
                                                    id="tipo_equipo" name="tipo_equipo" required onchange="cargarComponentesPredeterminados()">
                                                <option value="">Seleccione tipo de equipo</option>
                                                @foreach(App\Models\Diagnostico::TIPOS_EQUIPO as $key => $value)
                                                    <option value="{{ $key }}" {{ old('tipo_equipo', $diagnostico->tipo_equipo) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tipo_equipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="marca_equipo" class="form-label">Marca</label>
                                            <input type="text" class="form-control @error('marca_equipo') is-invalid @enderror" 
                                                   id="marca_equipo" name="marca_equipo" 
                                                   value="{{ old('marca_equipo', $diagnostico->marca_equipo) }}">
                                            @error('marca_equipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="modelo_equipo" class="form-label">Modelo</label>
                                            <input type="text" class="form-control @error('modelo_equipo') is-invalid @enderror" 
                                                   id="modelo_equipo" name="modelo_equipo" 
                                                   value="{{ old('modelo_equipo', $diagnostico->modelo_equipo) }}">
                                            @error('modelo_equipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado del diagnóstico -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">📊 Estado del Diagnóstico</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estado" class="form-label">Estado *</label>
                                            <select class="form-select @error('estado') is-invalid @enderror" 
                                                    id="estado" name="estado" required>
                                                @foreach(App\Models\Diagnostico::ESTADOS as $key => $value)
                                                    <option value="{{ $key }}" {{ old('estado', $diagnostico->estado) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('estado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_diagnostico" class="form-label">Fecha del Diagnóstico *</label>
                                            <input type="date" class="form-control @error('fecha_diagnostico') is-invalid @enderror" 
                                                   id="fecha_diagnostico" name="fecha_diagnostico" 
                                                   value="{{ old('fecha_diagnostico', $diagnostico->fecha_diagnostico->format('Y-m-d')) }}" required>
                                            @error('fecha_diagnostico')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del técnico -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">👨‍💼 Información del Técnico</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="tecnico_responsable" class="form-label">Técnico Responsable *</label>
                                    <input type="text" class="form-control @error('tecnico_responsable') is-invalid @enderror" 
                                           id="tecnico_responsable" name="tecnico_responsable" 
                                           value="{{ old('tecnico_responsable', $diagnostico->tecnico_responsable) }}" required>
                                    @error('tecnico_responsable')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('diagnosticos.show', $diagnostico) }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Diagnóstico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Cargar componentes al editar
document.addEventListener('DOMContentLoaded', function() {
    // Simular cambio en el tipo de equipo para cargar componentes
    setTimeout(() => {
        document.getElementById('tipo_equipo').dispatchEvent(new Event('change'));
    }, 500);
});
</script>
@endpush