@extends('layouts.app')

@section('title', 'Registrar Nuevo Equipo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Registrar Nuevo Equipo Informático</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('equipos.store') }}" method="POST" id="equipoForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numero_serie" class="form-label">Número de Serie *</label>
                                <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
                                       id="numero_serie" name="numero_serie" 
                                       value="{{ old('numero_serie') }}" 
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
                                        <option value="{{ $tipo->id }}" {{ old('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>
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
                                        <option value="{{ $fabricante->id }}" {{ old('fabricante_id') == $fabricante->id ? 'selected' : '' }}>
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
                                       value="{{ old('modelo') }}" 
                                       placeholder="Ingrese el modelo del equipo" required>
                                @error('modelo')
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
                                          placeholder="Describa las características y uso del equipo">{{ old('descripcion') }}</textarea>
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
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="componenteSelect" class="form-label">Seleccionar Componente</label>
                                                <select class="form-select" id="componenteSelect">
                                                    <option value="">Seleccionar componente para agregar</option>
                                                    @foreach($componentes as $componente)
                                                        <option value="{{ $componente->id }}" 
                                                            data-tipo="{{ $componente->tipoComponente->nombre ?? 'N/A' }}"
                                                            data-fabricante="{{ $componente->fabricante->nombre ?? 'N/A' }}"
                                                            data-modelo="{{ $componente->modelo }}"
                                                            data-serie="{{ $componente->numero_serie }}">
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
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-success w-100" onclick="agregarComponenteDesdeSelect()">
                                                    <i class="fas fa-plus"></i> Agregar Componente
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="componentes-container" class="mt-3">
                                        @if(old('componentes'))
                                            @foreach(old('componentes') as $index => $componente)
                                                @php
                                                    $comp = $componentes->find($componente['componente_id']);
                                                @endphp
                                                @if($comp)
                                                    <div class="componente-seleccionado border rounded p-3 mb-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>{{ $comp->tipoComponente->nombre ?? 'N/A' }}</strong>
                                                                - {{ $comp->fabricante->nombre ?? 'N/A' }} - 
                                                                {{ $comp->modelo }}
                                                                @if($comp->numero_serie)
                                                                    ({{ $comp->numero_serie }})
                                                                @endif
                                                                <input type="hidden" name="componentes[{{ $index }}][componente_id]" 
                                                                       value="{{ $componente['componente_id'] }}">
                                                            </div>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(this)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                                    <div id="componentes-vacios" class="alert alert-info mt-3" style="display: {{ old('componentes') && count(old('componentes')) > 0 ? 'none' : 'block' }};">
                                        <i class="fas fa-info-circle"></i> No se han agregado componentes aún.
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <small class="text-muted" id="contador-componentes">
                                            Componentes agregados: {{ old('componentes') ? count(old('componentes')) : 0 }}
                                        </small>
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
                            <i class="fas fa-save"></i> Guardar Equipo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let contadorComponentes = {{ old('componentes') ? count(old('componentes')) : 0 }};
const componentesAgregados = new Set();

// Inicializar componentes ya agregados desde old()
document.addEventListener('DOMContentLoaded', function() {
    actualizarContadorComponentes();
    mostrarMensajeVacioComponentes();
    
    @if(old('componentes'))
        @foreach(old('componentes') as $componente)
            componentesAgregados.add("{{ $componente['componente_id'] }}");
        @endforeach
    @endif
});

// Funciones para Componentes
function agregarComponenteDesdeSelect() {
    console.log('Función agregarComponenteDesdeSelect ejecutada');
    
    const select = document.getElementById('componenteSelect');
    const componenteId = select.value;
    
    console.log('Componente ID seleccionado:', componenteId);
    
    if (!componenteId) {
        alert('Por favor selecciona un componente');
        return;
    }
    
    if (componentesAgregados.has(componenteId)) {
        alert('Este componente ya ha sido agregado');
        return;
    }
    
    const option = select.options[select.selectedIndex];
    const tipo = option.getAttribute('data-tipo');
    const fabricante = option.getAttribute('data-fabricante');
    const modelo = option.getAttribute('data-modelo');
    const serie = option.getAttribute('data-serie');
    
    console.log('Datos del componente:', {tipo, fabricante, modelo, serie});
    
    const container = document.getElementById('componentes-container');
    
    const componenteDiv = document.createElement('div');
    componenteDiv.className = 'componente-seleccionado border rounded p-3 mb-2';
    componenteDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${tipo}</strong>
                - ${fabricante} - ${modelo}
                ${serie ? `(${serie})` : ''}
                <input type="hidden" name="componentes[${contadorComponentes}][componente_id]" value="${componenteId}">
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComponente(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    container.appendChild(componenteDiv);
    componentesAgregados.add(componenteId);
    contadorComponentes++;
    
    select.selectedIndex = 0;
    actualizarContadorComponentes();
    mostrarMensajeVacioComponentes();
    
    console.log('Componente agregado correctamente. Total:', contadorComponentes);
}

function eliminarComponente(boton) {
    const componenteDiv = boton.closest('.componente-seleccionado');
    const inputHidden = componenteDiv.querySelector('input[type="hidden"]');
    const componenteId = inputHidden.value;
    
    componenteDiv.remove();
    componentesAgregados.delete(componenteId);
    contadorComponentes--;
    
    actualizarContadorComponentes();
    mostrarMensajeVacioComponentes();
    reorganizarIndicesComponentes();
}

function reorganizarIndicesComponentes() {
    const componentes = document.querySelectorAll('.componente-seleccionado');
    contadorComponentes = componentes.length;
    
    componentes.forEach((componente, index) => {
        const input = componente.querySelector('input[type="hidden"]');
        input.name = `componentes[${index}][componente_id]`;
    });
}

function actualizarContadorComponentes() {
    const contador = document.getElementById('contador-componentes');
    contador.textContent = `Componentes agregados: ${contadorComponentes}`;
}

function mostrarMensajeVacioComponentes() {
    const mensajeVacio = document.getElementById('componentes-vacios');
    if (contadorComponentes === 0) {
        mensajeVacio.style.display = 'block';
    } else {
        mensajeVacio.style.display = 'none';
    }
}
</script>
@endsection