@extends('layouts.app')

@section('title', 'Crear Nueva Actividad')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Crear Nueva Actividad</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('actividades.store') }}" method="POST" id="actividadForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Actividad *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       placeholder="Ingrese el nombre de la actividad" required>
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
                                          placeholder="Describa la actividad y sus objetivos">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Programas Asociados -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Programas Asociados</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="programaSelect" class="form-label">Seleccionar Programa</label>
                                                <select class="form-select" id="programaSelect">
                                                    <option value="">Seleccionar programa para agregar</option>
                                                    @foreach($programas as $programa)
                                                        <option value="{{ $programa->id }}" 
                                                            data-nombre="{{ $programa->nombre }}"
                                                            data-version="{{ $programa->version }}"
                                                            data-fabricante="{{ $programa->fabricante ? $programa->fabricante->nombre : '' }}">
                                                            {{ $programa->nombre }}
                                                            @if($programa->version)
                                                                (v{{ $programa->version }})
                                                            @endif
                                                            @if($programa->fabricante)
                                                                - {{ $programa->fabricante->nombre }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-success w-100" onclick="agregarProgramaDesdeSelect()">
                                                    <i class="fas fa-plus"></i> Agregar Programa
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="programas-container" class="mt-3">
                                        @if(old('programas'))
                                            @foreach(old('programas') as $index => $programa)
                                                <div class="programa-seleccionado border rounded p-3 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $programas->find($programa['programa_id'])->nombre }}</strong>
                                                            @if($programas->find($programa['programa_id'])->version)
                                                                (v{{ $programas->find($programa['programa_id'])->version }})
                                                            @endif
                                                            @if($programas->find($programa['programa_id'])->fabricante)
                                                                - {{ $programas->find($programa['programa_id'])->fabricante->nombre }}
                                                            @endif
                                                            <input type="hidden" name="programas[{{ $index }}][programa_id]" 
                                                                   value="{{ $programa['programa_id'] }}">
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPrograma(this)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div id="programas-vacios" class="alert alert-info mt-3" style="display: none;">
                                        <i class="fas fa-info-circle"></i> No se han agregado programas aún.
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <small class="text-muted" id="contador-programas">Programas agregados: 0</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Tipos de Equipo Asociados -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Tipos de Equipo Asociados</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="tipoEquipoSelect" class="form-label">Seleccionar Tipo de Equipo</label>
                                                <select class="form-select" id="tipoEquipoSelect">
                                                    <option value="">Seleccionar tipo de equipo para agregar</option>
                                                    @foreach($tiposEquipo as $tipoEquipo)
                                                        <option value="{{ $tipoEquipo->id }}" 
                                                            data-nombre="{{ $tipoEquipo->nombre }}"
                                                            data-descripcion="{{ $tipoEquipo->descripcion }}">
                                                            {{ $tipoEquipo->nombre }}
                                                            @if($tipoEquipo->descripcion)
                                                                - {{ Str::limit($tipoEquipo->descripcion, 50) }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-success w-100" onclick="agregarTipoEquipoDesdeSelect()">
                                                    <i class="fas fa-plus"></i> Agregar Tipo de Equipo
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tipos-equipo-container" class="mt-3">
                                        @if(old('tipos_equipo'))
                                            @foreach(old('tipos_equipo') as $index => $tipoEquipo)
                                                <div class="tipo-equipo-seleccionado border rounded p-3 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $tiposEquipo->find($tipoEquipo['tipo_equipo_id'])->nombre }}</strong>
                                                            @if($tiposEquipo->find($tipoEquipo['tipo_equipo_id'])->descripcion)
                                                                <br><small class="text-muted">{{ $tiposEquipo->find($tipoEquipo['tipo_equipo_id'])->descripcion }}</small>
                                                            @endif
                                                            <input type="hidden" name="tipos_equipo[{{ $index }}][tipo_equipo_id]" 
                                                                   value="{{ $tipoEquipo['tipo_equipo_id'] }}">
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoEquipo(this)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div id="tipos-equipo-vacios" class="alert alert-info mt-3" style="display: none;">
                                        <i class="fas fa-info-circle"></i> No se han agregado tipos de equipo aún.
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <small class="text-muted" id="contador-tipos-equipo">Tipos de equipo agregados: 0</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('actividades.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Actividad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let contadorProgramas = {{ old('programas') ? count(old('programas')) : 0 }};
let contadorTiposEquipo = {{ old('tipos_equipo') ? count(old('tipos_equipo')) : 0 }};
const programasAgregados = new Set();
const tiposEquipoAgregados = new Set();

// Inicializar contadores
document.addEventListener('DOMContentLoaded', function() {
    actualizarContadorProgramas();
    actualizarContadorTiposEquipo();
    mostrarMensajeVacioProgramas();
    mostrarMensajeVacioTiposEquipo();
});

// Funciones para Programas
function agregarProgramaDesdeSelect() {
    const select = document.getElementById('programaSelect');
    const programaId = select.value;
    
    if (!programaId) {
        mostrarAlerta('Por favor selecciona un programa', 'warning');
        return;
    }
    
    if (programasAgregados.has(programaId)) {
        mostrarAlerta('Este programa ya ha sido agregado', 'warning');
        return;
    }
    
    const option = select.options[select.selectedIndex];
    const nombre = option.getAttribute('data-nombre');
    const version = option.getAttribute('data-version');
    const fabricante = option.getAttribute('data-fabricante');
    
    const container = document.getElementById('programas-container');
    const programaDiv = document.createElement('div');
    programaDiv.className = 'programa-seleccionado border rounded p-3 mb-2';
    programaDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${nombre}</strong>
                ${version ? `(v${version})` : ''}
                ${fabricante ? ` - ${fabricante}` : ''}
                <input type="hidden" name="programas[${contadorProgramas}][programa_id]" value="${programaId}">
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPrograma(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    container.appendChild(programaDiv);
    programasAgregados.add(programaId);
    contadorProgramas++;
    
    select.selectedIndex = 0;
    actualizarContadorProgramas();
    mostrarMensajeVacioProgramas();
    mostrarAlerta('Programa agregado correctamente', 'success');
}

function eliminarPrograma(boton) {
    const programaDiv = boton.closest('.programa-seleccionado');
    const programaId = programaDiv.querySelector('input[type="hidden"]').value;
    
    programaDiv.remove();
    programasAgregados.delete(programaId);
    contadorProgramas--;
    
    actualizarContadorProgramas();
    mostrarMensajeVacioProgramas();
    reorganizarIndicesProgramas();
}

function reorganizarIndicesProgramas() {
    const programas = document.querySelectorAll('.programa-seleccionado');
    programas.forEach((programa, index) => {
        const input = programa.querySelector('input[type="hidden"]');
        input.name = `programas[${index}][programa_id]`;
    });
    contadorProgramas = programas.length;
}

function actualizarContadorProgramas() {
    const contador = document.getElementById('contador-programas');
    contador.textContent = `Programas agregados: ${contadorProgramas}`;
}

function mostrarMensajeVacioProgramas() {
    const mensajeVacio = document.getElementById('programas-vacios');
    if (contadorProgramas === 0) {
        mensajeVacio.style.display = 'block';
    } else {
        mensajeVacio.style.display = 'none';
    }
}

// Funciones para Tipos de Equipo
function agregarTipoEquipoDesdeSelect() {
    const select = document.getElementById('tipoEquipoSelect');
    const tipoEquipoId = select.value;
    
    if (!tipoEquipoId) {
        mostrarAlerta('Por favor selecciona un tipo de equipo', 'warning');
        return;
    }
    
    if (tiposEquipoAgregados.has(tipoEquipoId)) {
        mostrarAlerta('Este tipo de equipo ya ha sido agregado', 'warning');
        return;
    }
    
    const option = select.options[select.selectedIndex];
    const nombre = option.getAttribute('data-nombre');
    const descripcion = option.getAttribute('data-descripcion');
    
    const container = document.getElementById('tipos-equipo-container');
    const tipoEquipoDiv = document.createElement('div');
    tipoEquipoDiv.className = 'tipo-equipo-seleccionado border rounded p-3 mb-2';
    tipoEquipoDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${nombre}</strong>
                ${descripcion ? `<br><small class="text-muted">${descripcion}</small>` : ''}
                <input type="hidden" name="tipos_equipo[${contadorTiposEquipo}][tipo_equipo_id]" value="${tipoEquipoId}">
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoEquipo(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    container.appendChild(tipoEquipoDiv);
    tiposEquipoAgregados.add(tipoEquipoId);
    contadorTiposEquipo++;
    
    select.selectedIndex = 0;
    actualizarContadorTiposEquipo();
    mostrarMensajeVacioTiposEquipo();
    mostrarAlerta('Tipo de equipo agregado correctamente', 'success');
}

function eliminarTipoEquipo(boton) {
    const tipoEquipoDiv = boton.closest('.tipo-equipo-seleccionado');
    const tipoEquipoId = tipoEquipoDiv.querySelector('input[type="hidden"]').value;
    
    tipoEquipoDiv.remove();
    tiposEquipoAgregados.delete(tipoEquipoId);
    contadorTiposEquipo--;
    
    actualizarContadorTiposEquipo();
    mostrarMensajeVacioTiposEquipo();
    reorganizarIndicesTiposEquipo();
}

function reorganizarIndicesTiposEquipo() {
    const tiposEquipo = document.querySelectorAll('.tipo-equipo-seleccionado');
    tiposEquipo.forEach((tipoEquipo, index) => {
        const input = tipoEquipo.querySelector('input[type="hidden"]');
        input.name = `tipos_equipo[${index}][tipo_equipo_id]`;
    });
    contadorTiposEquipo = tiposEquipo.length;
}

function actualizarContadorTiposEquipo() {
    const contador = document.getElementById('contador-tipos-equipo');
    contador.textContent = `Tipos de equipo agregados: ${contadorTiposEquipo}`;
}

function mostrarMensajeVacioTiposEquipo() {
    const mensajeVacio = document.getElementById('tipos-equipo-vacios');
    if (contadorTiposEquipo === 0) {
        mensajeVacio.style.display = 'block';
    } else {
        mensajeVacio.style.display = 'none';
    }
}

// Función general para mostrar alertas
function mostrarAlerta(mensaje, tipo) {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const cardHeader = document.querySelector('.card-header');
    cardHeader.parentNode.insertBefore(alerta, cardHeader.nextSibling);
    
    setTimeout(() => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    }, 3000);
}

// Validación del formulario
document.getElementById('actividadForm').addEventListener('submit', function(e) {
    let hasErrors = false;
    
    if (contadorProgramas === 0 && contadorTiposEquipo === 0) {
        e.preventDefault();
        mostrarAlerta('Debe agregar al menos un programa o un tipo de equipo', 'danger');
        return false;
    }
});
</script>

@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.25rem;
    }
    
    .programa-seleccionado,
    .tipo-equipo-seleccionado {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .programa-seleccionado:hover,
    .tipo-equipo-seleccionado:hover {
        background-color: #e9ecef;
    }
    
    .alert {
        margin-bottom: 1rem;
    }
</style>
@endpush