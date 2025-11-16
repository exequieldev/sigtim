@extends('layouts.app')

@section('title', 'Editar Actividad')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Editar Actividad: {{ $actividade->nombre }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('actividades.update', $actividade) }}" method="POST" id="actividadForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Actividad *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" 
                                       value="{{ old('nombre', $actividade->nombre) }}" 
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
                                          placeholder="Describa la actividad y sus objetivos">{{ old('descripcion', $actividade->descripcion) }}</textarea>
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
                                        @php
                                            $programasExistentes = old('programas', []);
                                            // Si no hay datos del formulario, usar los programas existentes de la actividad
                                            if (empty($programasExistentes)) {
                                                $programasExistentes = $actividade->programas->map(function($programa) {
                                                    return ['programa_id' => $programa->id];
                                                })->toArray();
                                            }
                                        @endphp

                                        @foreach($programasExistentes as $index => $programa)
                                            @php
                                                $programaId = is_array($programa) ? ($programa['programa_id'] ?? null) : $programa;
                                                $programaModel = $programas->find($programaId);
                                            @endphp
                                            @if($programaModel)
                                                <div class="programa-seleccionado border rounded p-3 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $programaModel->nombre }}</strong>
                                                            @if($programaModel->version)
                                                                (v{{ $programaModel->version }})
                                                            @endif
                                                            @if($programaModel->fabricante)
                                                                - {{ $programaModel->fabricante->nombre }}
                                                            @endif
                                                            <input type="hidden" name="programas[{{ $index }}][programa_id]" 
                                                                   value="{{ $programaId }}">
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPrograma(this)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div id="programas-vacios" class="alert alert-info mt-3" 
                                         style="display: {{ count($programasExistentes) > 0 ? 'none' : 'block' }};">
                                        <i class="fas fa-info-circle"></i> No se han agregado programas aún.
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <small class="text-muted" id="contador-programas">
                                            Programas agregados: {{ count($programasExistentes) }}
                                        </small>
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
                                        @php
                                            $tiposEquipoExistentes = old('tipos_equipo', []);
                                            // Si no hay datos del formulario, usar los tipos de equipo existentes de la actividad
                                            if (empty($tiposEquipoExistentes)) {
                                                $tiposEquipoExistentes = $actividade->tiposEquipo->map(function($tipoEquipo) {
                                                    return ['tipo_equipo_id' => $tipoEquipo->id];
                                                })->toArray();
                                            }
                                        @endphp

                                        @foreach($tiposEquipoExistentes as $index => $tipoEquipo)
                                            @php
                                                $tipoEquipoId = is_array($tipoEquipo) ? ($tipoEquipo['tipo_equipo_id'] ?? null) : $tipoEquipo;
                                                $tipoEquipoModel = $tiposEquipo->find($tipoEquipoId);
                                            @endphp
                                            @if($tipoEquipoModel)
                                                <div class="tipo-equipo-seleccionado border rounded p-3 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $tipoEquipoModel->nombre }}</strong>
                                                            @if($tipoEquipoModel->descripcion)
                                                                <br><small class="text-muted">{{ $tipoEquipoModel->descripcion }}</small>
                                                            @endif
                                                            <input type="hidden" name="tipos_equipo[{{ $index }}][tipo_equipo_id]" 
                                                                   value="{{ $tipoEquipoId }}">
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoEquipo(this)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div id="tipos-equipo-vacios" class="alert alert-info mt-3" 
                                         style="display: {{ count($tiposEquipoExistentes) > 0 ? 'none' : 'block' }};">
                                        <i class="fas fa-info-circle"></i> No se han agregado tipos de equipo aún.
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <small class="text-muted" id="contador-tipos-equipo">
                                            Tipos de equipo agregados: {{ count($tiposEquipoExistentes) }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('actividades.show', $actividade) }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Actividad
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
                            <strong>Creación:</strong> {{ $actividade->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Última actualización:</strong> {{ $actividade->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Inicializar con los datos correctos
let contadorProgramas = {{ count($programasExistentes) }};
let contadorTiposEquipo = {{ count($tiposEquipoExistentes) }};
const programasAgregados = new Set();
const tiposEquipoAgregados = new Set();

// Inicializar contadores y sets
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando formulario de edición...');
    
    // Inicializar programas existentes
    @foreach($programasExistentes as $programa)
        @php
            $programaId = is_array($programa) ? ($programa['programa_id'] ?? null) : $programa;
        @endphp
        @if($programaId)
            programasAgregados.add('{{ $programaId }}');
        @endif
    @endforeach

    // Inicializar tipos de equipo existentes
    @foreach($tiposEquipoExistentes as $tipoEquipo)
        @php
            $tipoEquipoId = is_array($tipoEquipo) ? ($tipoEquipo['tipo_equipo_id'] ?? null) : $tipoEquipo;
        @endphp
        @if($tipoEquipoId)
            tiposEquipoAgregados.add('{{ $tipoEquipoId }}');
        @endif
    @endforeach

    console.log('Programas agregados:', programasAgregados);
    console.log('Tipos de equipo agregados:', tiposEquipoAgregados);

    actualizarContadorProgramas();
    actualizarContadorTiposEquipo();
    mostrarMensajeVacioProgramas();
    mostrarMensajeVacioTiposEquipo();
});

// Funciones para Programas
function agregarProgramaDesdeSelect() {
    console.log('Agregando programa...');
    const select = document.getElementById('programaSelect');
    const programaId = select.value;
    
    console.log('Programa ID seleccionado:', programaId);
    
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
    
    console.log('Programa agregado. Total:', contadorProgramas);
}

function eliminarPrograma(boton) {
    const programaDiv = boton.closest('.programa-seleccionado');
    const inputHidden = programaDiv.querySelector('input[type="hidden"]');
    const programaId = inputHidden.value;
    
    programaDiv.remove();
    programasAgregados.delete(programaId);
    contadorProgramas--;
    
    actualizarContadorProgramas();
    mostrarMensajeVacioProgramas();
    reorganizarIndicesProgramas();
}

function reorganizarIndicesProgramas() {
    const programas = document.querySelectorAll('.programa-seleccionado');
    contadorProgramas = programas.length;
    
    programas.forEach((programa, index) => {
        const input = programa.querySelector('input[type="hidden"]');
        input.name = `programas[${index}][programa_id]`;
    });
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
    console.log('Agregando tipo de equipo...');
    const select = document.getElementById('tipoEquipoSelect');
    const tipoEquipoId = select.value;
    
    console.log('Tipo de equipo ID seleccionado:', tipoEquipoId);
    
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
    
    console.log('Tipo de equipo agregado. Total:', contadorTiposEquipo);
}

function eliminarTipoEquipo(boton) {
    const tipoEquipoDiv = boton.closest('.tipo-equipo-seleccionado');
    const inputHidden = tipoEquipoDiv.querySelector('input[type="hidden"]');
    const tipoEquipoId = inputHidden.value;
    
    tipoEquipoDiv.remove();
    tiposEquipoAgregados.delete(tipoEquipoId);
    contadorTiposEquipo--;
    
    actualizarContadorTiposEquipo();
    mostrarMensajeVacioTiposEquipo();
    reorganizarIndicesTiposEquipo();
}

function reorganizarIndicesTiposEquipo() {
    const tiposEquipo = document.querySelectorAll('.tipo-equipo-seleccionado');
    contadorTiposEquipo = tiposEquipo.length;
    
    tiposEquipo.forEach((tipoEquipo, index) => {
        const input = tipoEquipo.querySelector('input[type="hidden"]');
        input.name = `tipos_equipo[${index}][tipo_equipo_id]`;
    });
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
    // Eliminar alertas existentes
    const alertasExistentes = document.querySelectorAll('.alert[role="alert"]');
    alertasExistentes.forEach(alerta => alerta.remove());
    
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.setAttribute('role', 'alert');
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const cardHeader = document.querySelector('.card-header');
    cardHeader.parentNode.insertBefore(alerta, cardHeader.nextSibling);
    
    setTimeout(() => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    }, 4000);
}

// Validación del formulario
document.getElementById('actividadForm').addEventListener('submit', function(e) {
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