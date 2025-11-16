@extends('layouts.app')

@section('title', 'Editar Equipo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Editar Equipo Informático</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numero_serie" class="form-label">Número de Serie *</label>
                                <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
                                       id="numero_serie" name="numero_serie" 
                                       value="{{ old('numero_serie', $equipo->numero_serie) }}" 
                                       placeholder="Ingrese el número de serie del equipo" required>
                                @error('numero_serie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_equipo_id" class="form-label">Tipo de Equipo *</label>
                                <select class="form-select @error('tipo_equipo_id') is-invalid @enderror" 
                                        id="tipo_equipo_id" name="tipo_equipo_id" required>
                                    <option value="">Seleccionar tipo</option>
                                    @foreach($tiposEquipo as $tipo)
                                        <option value="{{ $tipo->id }}" 
                                            {{ old('tipo_equipo_id', $equipo->tipo_equipo_id) == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_equipo_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fabricante_id" class="form-label">Fabricante *</label>
                                <select class="form-select @error('fabricante_id') is-invalid @enderror" 
                                        id="fabricante_id" name="fabricante_id" required>
                                    <option value="">Seleccionar fabricante</option>
                                    @foreach($fabricantes as $fabricante)
                                        <option value="{{ $fabricante->id }}" 
                                            {{ old('fabricante_id', $equipo->fabricante_id) == $fabricante->id ? 'selected' : '' }}>
                                            {{ $fabricante->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fabricante_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modelo" class="form-label">Modelo *</label>
                                <input type="text" class="form-control @error('modelo') is-invalid @enderror" 
                                       id="modelo" name="modelo" 
                                       value="{{ old('modelo', $equipo->modelo) }}" 
                                       placeholder="Ingrese el modelo del equipo" required>
                                @error('modelo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición *</label>
                                <input type="date" class="form-control @error('fecha_adquisicion') is-invalid @enderror" 
                                       id="fecha_adquisicion" name="fecha_adquisicion" 
                                       value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion->format('Y-m-d')) }}" 
                                       required>
                                @error('fecha_adquisicion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_instalacion" class="form-label">Fecha de Instalación</label>
                                <input type="date" class="form-control @error('fecha_instalacion') is-invalid @enderror" 
                                       id="fecha_instalacion" name="fecha_instalacion" 
                                       value="{{ old('fecha_instalacion', $equipo->fecha_instalacion ? $equipo->fecha_instalacion->format('Y-m-d') : '') }}">
                                @error('fecha_instalacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" name="estado" required>
                                    <option value="">Seleccionar estado</option>
                                    <option value="Activo" {{ old('estado', $equipo->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Mantenimiento" {{ old('estado', $equipo->estado) == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                    <option value="Baja" {{ old('estado', $equipo->estado) == 'Baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="En Reparación" {{ old('estado', $equipo->estado) == 'En Reparación' ? 'selected' : '' }}>En Reparación</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" name="descripcion" 
                                          rows="3" 
                                          placeholder="Describa las características y uso del equipo">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Componentes del Equipo -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Componentes del Equipo</h6>
                                </div>
                                <div class="card-body">
                                    <div id="componentes-container">
                                        @php
                                            $componentesSeleccionados = old('componentes', $equipo->componentes->map(function($componente) {
                                                return ['componente_id' => $componente->id];
                                            })->toArray());
                                        @endphp

                                        @if(count($componentesSeleccionados) > 0)
                                            @foreach($componentesSeleccionados as $index => $componente)
                                                <div class="componente-item border-bottom pb-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="mb-3">
                                                                <label class="form-label">Componente *</label>
                                                                <select class="form-select @error('componentes.' . $index . '.componente_id') is-invalid @enderror" 
                                                                        name="componentes[{{ $index }}][componente_id]" required>
                                                                    <option value="">Seleccionar componente</option>
                                                                    @foreach($componentes as $comp)
                                                                        <option value="{{ $comp->id }}" 
                                                                            {{ ($componente['componente_id'] ?? '') == $comp->id ? 'selected' : '' }}>
                                                                            {{ $comp->tipoComponente->nombre ?? 'N/A' }} - 
                                                                            {{ $comp->fabricante->nombre ?? 'N/A' }} - 
                                                                            {{ $comp->modelo }}
                                                                            @if($comp->numero_serie)
                                                                                ({{ $comp->numero_serie }})
                                                                            @endif
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('componentes.' . $index . '.componente_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">&nbsp;</label>
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(this)" style="margin-top: 8px;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Primer componente vacío -->
                                            <div class="componente-item border-bottom pb-3 mb-3">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="mb-3">
                                                            <label class="form-label">Componente *</label>
                                                            <select class="form-select @error('componentes.0.componente_id') is-invalid @enderror" 
                                                                    name="componentes[0][componente_id]" required>
                                                                <option value="">Seleccionar componente</option>
                                                                @foreach($componentes as $componente)
                                                                    <option value="{{ $componente->id }}">
                                                                        {{ $componente->tipoComponente->nombre ?? 'N/A' }} - 
                                                                        {{ $componente->fabricante->nombre ?? 'N/A' }} - 
                                                                        {{ $componente->modelo }}
                                                                        @if($componente->numero_serie)
                                                                            ({{ $componente->numero_serie }})
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('componentes.0.componente_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="mb-3">
                                                            <label class="form-label">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(this)" style="margin-top: 8px;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <button type="button" class="btn btn-success btn-sm" onclick="agregarComponente()">
                                            <i class="fas fa-plus"></i> Agregar Componente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('equipos.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Equipo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let contadorComponentes = {{ count(old('componentes', $equipo->componentes->toArray())) }};

function agregarComponente() {
    const container = document.getElementById('componentes-container');
    
    const nuevoComponente = document.createElement('div');
    nuevoComponente.className = 'componente-item border-bottom pb-3 mb-3';
    nuevoComponente.innerHTML = `
        <div class="row">
            <div class="col-md-11">
                <div class="mb-3">
                    <label class="form-label">Componente *</label>
                    <select class="form-select" name="componentes[${contadorComponentes}][componente_id]" required>
                        <option value="">Seleccionar componente</option>
                        @foreach($componentes as $componente)
                            <option value="{{ $componente->id }}">
                                {{ $componente->tipoComponente->nombre ?? 'N/A' }} - 
                                {{ $componente->fabricante->nombre ?? 'N/A' }} - 
                                {{ $componente->modelo }}
                                @if($componente->numero_serie)
                                    ({{ $componente->numero_serie }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(this)" style="margin-top: 8px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoComponente);
    contadorComponentes++;
}

function eliminarComponente(boton) {
    const item = boton.closest('.componente-item');
    const container = document.getElementById('componentes-container');
    
    if (container.children.length > 1) {
        item.remove();
    } else {
        alert('Debe haber al menos un componente');
    }
}
</script>
@endsection