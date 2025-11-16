@extends('layouts.app')

@section('title', 'Editar Programa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Editar Programa: {{ $programa->nombre }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('programas.update', $programa) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Programa *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" 
                                       value="{{ old('nombre', $programa->nombre) }}" 
                                       placeholder="Ingrese el nombre del programa" required>
                                @error('nombre')
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
                                          placeholder="Describa las funciones y características del programa">{{ old('descripcion', $programa->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="version" class="form-label">Versión</label>
                                <input type="text" class="form-control @error('version') is-invalid @enderror" 
                                       id="version" name="version" 
                                       value="{{ old('version', $programa->version) }}" 
                                       placeholder="Ej: 1.0.0, 2023, etc.">
                                @error('version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fabricante_id" class="form-label">Fabricante/Desarrollador</label>
                                <select class="form-select @error('fabricante_id') is-invalid @enderror" 
                                        id="fabricante_id" name="fabricante_id">
                                    <option value="">Seleccionar fabricante</option>
                                    @foreach($fabricantes as $fabricante)
                                        <option value="{{ $fabricante->id }}" 
                                            {{ old('fabricante_id', $programa->fabricante_id) == $fabricante->id ? 'selected' : '' }}>
                                            {{ $fabricante->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fabricante_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="sistema_operativo" class="form-label">Sistema Operativo Compatible</label>
                                <select class="form-select @error('sistema_operativo') is-invalid @enderror" 
                                        id="sistema_operativo" name="sistema_operativo">
                                    <option value="">Seleccionar sistema operativo</option>
                                    <option value="Windows" {{ old('sistema_operativo', $programa->sistema_operativo) == 'Windows' ? 'selected' : '' }}>Windows</option>
                                    <option value="Linux" {{ old('sistema_operativo', $programa->sistema_operativo) == 'Linux' ? 'selected' : '' }}>Linux</option>
                                    <option value="macOS" {{ old('sistema_operativo', $programa->sistema_operativo) == 'macOS' ? 'selected' : '' }}>macOS</option>
                                    <option value="Multiplataforma" {{ old('sistema_operativo', $programa->sistema_operativo) == 'Multiplataforma' ? 'selected' : '' }}>Multiplataforma</option>
                                    <option value="Web" {{ old('sistema_operativo', $programa->sistema_operativo) == 'Web' ? 'selected' : '' }}>Aplicación Web</option>
                                    <option value="Android" {{ old('sistema_operativo', $programa->sistema_operativo) == 'Android' ? 'selected' : '' }}>Android</option>
                                    <option value="iOS" {{ old('sistema_operativo', $programa->sistema_operativo) == 'iOS' ? 'selected' : '' }}>iOS</option>
                                    <option value="Otro" {{ old('sistema_operativo', $programa->sistema_operativo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('sistema_operativo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Requisitos del Programa -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Requisitos del Sistema</h6>
                                </div>
                                <div class="card-body">
                                    <div id="requisitos-container">
                                        @php
                                            $requisitosExistentes = old('requisitos', $programa->requisitos->toArray());
                                            $indice = 0;
                                        @endphp

                                        @if(count($requisitosExistentes) > 0)
                                            @foreach($requisitosExistentes as $requisito)
                                                <div class="requisito-item border-bottom pb-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tipo de Componente *</label>
                                                                <select class="form-select @error('requisitos.'.$indice.'.tipo_componente_id') is-invalid @enderror" 
                                                                        name="requisitos[{{ $indice }}][tipo_componente_id]" required>
                                                                    <option value="">Seleccionar tipo</option>
                                                                    @foreach($tiposComponente as $tipo)
                                                                        <option value="{{ $tipo->id }}" 
                                                                            {{ old('requisitos.'.$indice.'.tipo_componente_id', $requisito['tipo_componente_id'] ?? '') == $tipo->id ? 'selected' : '' }}>
                                                                            {{ $tipo->nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('requisitos.'.$indice.'.tipo_componente_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label class="form-label">Unidad de Medida *</label>
                                                                <select class="form-select @error('requisitos.'.$indice.'.unidad_medida') is-invalid @enderror" 
                                                                        name="requisitos[{{ $indice }}][unidad_medida]" required>
                                                                    <option value="">Seleccionar unidad</option>
                                                                    @foreach($unidadesMedida as $unidad)
                                                                        <option value="{{ $unidad }}" 
                                                                            {{ old('requisitos.'.$indice.'.unidad_medida', $requisito['unidad_medida'] ?? '') == $unidad ? 'selected' : '' }}>
                                                                            {{ $unidad }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('requisitos.'.$indice.'.unidad_medida')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Requisito Mínimo *</label>
                                                                <input type="text" class="form-control @error('requisitos.'.$indice.'.requisito_minimo') is-invalid @enderror" 
                                                                       name="requisitos[{{ $indice }}][requisito_minimo]" 
                                                                       value="{{ old('requisitos.'.$indice.'.requisito_minimo', $requisito['requisito_minimo'] ?? '') }}"
                                                                       placeholder="Ej: 4, 2.5, 8, etc." required>
                                                                @error('requisitos.'.$indice.'.requisito_minimo')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Requisito Recomendado</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control @error('requisitos.'.$indice.'.requisito_recomendado') is-invalid @enderror" 
                                                                           name="requisitos[{{ $indice }}][requisito_recomendado]" 
                                                                           value="{{ old('requisitos.'.$indice.'.requisito_recomendado', $requisito['requisito_recomendado'] ?? '') }}"
                                                                           placeholder="Ej: 8, 3.2, 16, etc.">
                                                                    <span class="input-group-text bg-light">
                                                                        <small class="text-muted">misma unidad</small>
                                                                    </span>
                                                                </div>
                                                                @error('requisitos.'.$indice.'.requisito_recomendado')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">&nbsp;</label>
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarRequisito(this)" style="margin-top: 8px;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $indice++; @endphp
                                            @endforeach
                                        @else
                                            <!-- Primer requisito vacío -->
                                            <div class="requisito-item border-bottom pb-3 mb-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tipo de Componente *</label>
                                                            <select class="form-select @error('requisitos.0.tipo_componente_id') is-invalid @enderror" 
                                                                    name="requisitos[0][tipo_componente_id]" required>
                                                                <option value="">Seleccionar tipo</option>
                                                                @foreach($tiposComponente as $tipo)
                                                                    <option value="{{ $tipo->id }}" 
                                                                        {{ old('requisitos.0.tipo_componente_id') == $tipo->id ? 'selected' : '' }}>
                                                                        {{ $tipo->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('requisitos.0.tipo_componente_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <label class="form-label">Unidad de Medida *</label>
                                                            <select class="form-select @error('requisitos.0.unidad_medida') is-invalid @enderror" 
                                                                    name="requisitos[0][unidad_medida]" required>
                                                                <option value="">Seleccionar unidad</option>
                                                                @foreach($unidadesMedida as $unidad)
                                                                    <option value="{{ $unidad }}" 
                                                                        {{ old('requisitos.0.unidad_medida') == $unidad ? 'selected' : '' }}>
                                                                        {{ $unidad }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('requisitos.0.unidad_medida')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Requisito Mínimo *</label>
                                                            <input type="text" class="form-control @error('requisitos.0.requisito_minimo') is-invalid @enderror" 
                                                                   name="requisitos[0][requisito_minimo]" 
                                                                   value="{{ old('requisitos.0.requisito_minimo') }}"
                                                                   placeholder="Ej: 4, 2.5, 8, etc." required>
                                                            @error('requisitos.0.requisito_minimo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Requisito Recomendado</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control @error('requisitos.0.requisito_recomendado') is-invalid @enderror" 
                                                                       name="requisitos[0][requisito_recomendado]" 
                                                                       value="{{ old('requisitos.0.requisito_recomendado') }}"
                                                                       placeholder="Ej: 8, 3.2, 16, etc.">
                                                                <span class="input-group-text bg-light">
                                                                    <small class="text-muted">misma unidad</small>
                                                                </span>
                                                            </div>
                                                            @error('requisitos.0.requisito_recomendado')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="mb-3">
                                                            <label class="form-label">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarRequisito(this)" style="margin-top: 8px;">
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
                                        <button type="button" class="btn btn-success btn-sm" onclick="agregarRequisito()">
                                            <i class="fas fa-plus"></i> Agregar Requisito
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('programas.show', $programa) }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Programa
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Información del Registro</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Creación:</strong> {{ $programa->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Última actualización:</strong> {{ $programa->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let contadorRequisitos = {{ count($requisitosExistentes) > 0 ? count($requisitosExistentes) : 1 }};

function agregarRequisito() {
    const container = document.getElementById('requisitos-container');
    
    const nuevoRequisito = document.createElement('div');
    nuevoRequisito.className = 'requisito-item border-bottom pb-3 mb-3';
    nuevoRequisito.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">Tipo de Componente *</label>
                    <select class="form-select" name="requisitos[${contadorRequisitos}][tipo_componente_id]" required>
                        <option value="">Seleccionar tipo</option>
                        @foreach($tiposComponente as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Unidad de Medida *</label>
                    <select class="form-select" name="requisitos[${contadorRequisitos}][unidad_medida]" required>
                        <option value="">Seleccionar unidad</option>
                        @foreach($unidadesMedida as $unidad)
                            <option value="{{ $unidad }}">{{ $unidad }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">Requisito Mínimo *</label>
                    <input type="text" class="form-control" 
                           name="requisitos[${contadorRequisitos}][requisito_minimo]" 
                           placeholder="Ej: 4, 2.5, 8, etc." required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">Requisito Recomendado</label>
                    <div class="input-group">
                        <input type="text" class="form-control" 
                               name="requisitos[${contadorRequisitos}][requisito_recomendado]" 
                               placeholder="Ej: 8, 3.2, 16, etc.">
                        <span class="input-group-text bg-light">
                            <small class="text-muted">misma unidad</small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarRequisito(this)" style="margin-top: 8px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoRequisito);
    contadorRequisitos++;
}

function eliminarRequisito(boton) {
    const item = boton.closest('.requisito-item');
    const container = document.getElementById('requisitos-container');
    
    if (container.children.length > 1) {
        item.remove();
    } else {
        alert('Debe haber al menos un requisito');
    }
}
</script>

@endsection