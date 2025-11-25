@extends('layouts.app')

@section('title', 'Crear Nueva Solicitud')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Crear Nueva Solicitud</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('solicitudes.store') }}" method="POST" id="solicitudForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="empleado_id" class="form-label">Empleado *</label>
                                <select class="form-select @error('empleado_id') is-invalid @enderror" 
                                        id="empleado_id" name="empleado_id" required>
                                    <option value="">Seleccionar empleado</option>
                                    @foreach($empleados as $empleado)
                                        <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                            {{ $empleado->nombre }} {{ $empleado->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('empleado_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_solicitud_id" class="form-label">Tipo de Solicitud *</label>
                                <select class="form-select @error('tipo_solicitud_id') is-invalid @enderror" 
                                        id="tipo_solicitud_id" name="tipo_solicitud_id" required onchange="toggleSections()">
                                    <option value="">Seleccionar tipo de solicitud</option>
                                    @foreach($tipoSolicitudes as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('tipo_solicitud_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_solicitud_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Equipo para Reparación -->
                    <div class="row mt-4" id="equipo-section" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h6 class="card-title mb-0">Equipo a Reparar</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="equipo_id" class="form-label">Seleccionar Equipo *</label>
                                        <select class="form-select @error('equipo_id') is-invalid @enderror" 
                                                id="equipo_id" name="equipo_id">
                                            <option value="">Seleccionar equipo</option>
                                            <!-- Los equipos se cargarán dinámicamente -->
                                        </select>
                                        @error('equipo_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Solo se muestran los equipos activos asignados al empleado seleccionado.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Actividades Asociadas -->
                    <div class="row mt-4" id="actividades-section">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Actividades Asociadas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="actividadSelect" class="form-label">Seleccionar Actividad</label>
                                                <select class="form-select" id="actividadSelect">
                                                    <option value="">Seleccionar actividad para agregar</option>
                                                    @foreach($actividades as $actividad)
                                                        <option value="{{ $actividad->id }}" 
                                                            data-nombre="{{ $actividad->nombre }}">
                                                            {{ $actividad->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-success w-100" onclick="agregarActividadDesdeSelect()">
                                                    <i class="fas fa-plus"></i> Agregar Actividad
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="actividades-container" class="mt-3">
                                        @if(old('actividades'))
                                            @foreach(old('actividades') as $index => $actividad)
                                                <div class="actividad-seleccionada border rounded p-3 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $actividades->find($actividad['actividad_id'])->nombre }}</strong>
                                                            <input type="hidden" name="actividades[{{ $index }}][actividad_id]" 
                                                                   value="{{ $actividad['actividad_id'] }}">
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(this)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div id="actividades-vacios" class="alert alert-info mt-3" style="display: none;">
                                        <i class="fas fa-info-circle"></i> No se han agregado actividades aún.
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">* Campos obligatorios</small>
                                        <small class="text-muted" id="contador-actividades">Actividades agregadas: 0</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let contadorActividades = {{ old('actividades') ? count(old('actividades')) : 0 }};
const actividadesAgregadas = new Set();
let tipoSolicitudesData = @json($tipoSolicitudes);

// Inicializar el contador y verificar tipo de solicitud inicial
document.addEventListener('DOMContentLoaded', function() {
    actualizarContador();
    mostrarMensajeVacio();
    toggleSections(); // Verificar al cargar la página
    
    // Cargar equipos si ya hay un empleado seleccionado (en caso de error de validación)
    const empleadoId = document.getElementById('empleado_id').value;
    if (empleadoId) {
        cargarEquiposDelEmpleado(empleadoId);
    }
});

// Función para mostrar/ocultar secciones según el tipo de solicitud
function toggleSections() {
    const tipoSolicitudSelect = document.getElementById('tipo_solicitud_id');
    const equipoSection = document.getElementById('equipo-section');
    const actividadesSection = document.getElementById('actividades-section');
    const equipoSelect = document.getElementById('equipo_id');
    
    if (tipoSolicitudSelect.value) {
        const tipoSeleccionado = tipoSolicitudesData.find(tipo => tipo.id == tipoSolicitudSelect.value);
        
        if (tipoSeleccionado && tipoSeleccionado.nombre.toLowerCase().includes('reparación')) {
            // Mostrar equipo y ocultar actividades
            equipoSection.style.display = 'block';
            actividadesSection.style.display = 'none';
            equipoSelect.required = true;
            
            // Cargar equipos del empleado seleccionado
            const empleadoId = document.getElementById('empleado_id').value;
            if (empleadoId) {
                cargarEquiposDelEmpleado(empleadoId);
            }
        } else {
            // Mostrar actividades y ocultar equipo
            equipoSection.style.display = 'none';
            actividadesSection.style.display = 'block';
            equipoSelect.required = false;
            equipoSelect.selectedIndex = 0;
        }
    } else {
        // Por defecto mostrar actividades
        equipoSection.style.display = 'none';
        actividadesSection.style.display = 'block';
        equipoSelect.required = false;
    }
}

// Función para cargar equipos del empleado
// Función para cargar equipos del empleado - CORREGIDA
// Función para cargar equipos del empleado - ACTUALIZADA CON TIPO
function cargarEquiposDelEmpleado(empleadoId) {
    const equipoSelect = document.getElementById('equipo_id');
    
    // Mostrar loading
    equipoSelect.innerHTML = '<option value="">Cargando equipos...</option>';
    equipoSelect.disabled = true;
    
    fetch(`/empleados/${empleadoId}/equipos-activos`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar equipos');
            }
            return response.json();
        })
        .then(data => {
            console.log('Equipos recibidos:', data); // Para ver en consola
            
            equipoSelect.innerHTML = '<option value="">Seleccionar equipo</option>';
            
            if (data && data.length > 0) {
                data.forEach(equipo => {
                    const option = document.createElement('option');
                    option.value = equipo.id;
                    
                    // INCLUIR EL TIPO DE EQUIPO
                    let texto = '';
                    if (equipo.tipo_equipo) texto += `[${equipo.tipo_equipo}] `;
                    // texto += equipo.numero_serie || 'Sin número de serie';
                    if (equipo.modelo) texto += ` - ${equipo.modelo}`;
                    // if (equipo.descripcion) texto += ` (${equipo.descripcion})`;
                    
                    option.textContent = texto;
                    equipoSelect.appendChild(option);
                });
                
                // Seleccionar valor anterior si existe
                const oldEquipoId = "{{ old('equipo_id') }}";
                if (oldEquipoId) {
                    equipoSelect.value = oldEquipoId;
                }
                
                equipoSelect.disabled = false;
            } else {
                equipoSelect.innerHTML = '<option value="">No hay equipos asignados</option>';
                mostrarAlerta('El empleado seleccionado no tiene equipos asignados activos.', 'warning');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            equipoSelect.innerHTML = '<option value="">Error al cargar equipos</option>';
            mostrarAlerta('Error al cargar los equipos del empleado.', 'danger');
        });
}

// Event listener para cambio de empleado
document.getElementById('empleado_id').addEventListener('change', function() {
    const equipoSection = document.getElementById('equipo-section');
    
    // Solo cargar equipos si la sección de equipo está visible
    if (equipoSection.style.display === 'block' && this.value) {
        cargarEquiposDelEmpleado(this.value);
    }
});

// Funciones para actividades
function agregarActividadDesdeSelect() {
    const select = document.getElementById('actividadSelect');
    const actividadId = select.value;
    
    if (!actividadId) {
        mostrarAlerta('Por favor selecciona una actividad', 'warning');
        return;
    }
    
    if (actividadesAgregadas.has(actividadId)) {
        mostrarAlerta('Esta actividad ya ha sido agregada', 'warning');
        return;
    }
    
    const option = select.options[select.selectedIndex];
    const nombre = option.getAttribute('data-nombre');
    
    const container = document.getElementById('actividades-container');
    const actividadDiv = document.createElement('div');
    actividadDiv.className = 'actividad-seleccionada border rounded p-3 mb-2';
    actividadDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${nombre}</strong>
                <input type="hidden" name="actividades[${contadorActividades}][actividad_id]" value="${actividadId}">
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    container.appendChild(actividadDiv);
    actividadesAgregadas.add(actividadId);
    contadorActividades++;
    
    select.selectedIndex = 0;
    actualizarContador();
    mostrarMensajeVacio();
    mostrarAlerta('Actividad agregada correctamente', 'success');
}

function eliminarActividad(boton) {
    const actividadDiv = boton.closest('.actividad-seleccionada');
    const actividadId = actividadDiv.querySelector('input[type="hidden"]').value;
    
    actividadDiv.remove();
    actividadesAgregadas.delete(actividadId);
    contadorActividades--;
    
    actualizarContador();
    mostrarMensajeVacio();
    reorganizarIndices();
}

function reorganizarIndices() {
    const actividades = document.querySelectorAll('.actividad-seleccionada');
    actividades.forEach((actividad, index) => {
        const input = actividad.querySelector('input[type="hidden"]');
        input.name = `actividades[${index}][actividad_id]`;
    });
    contadorActividades = actividades.length;
}

function actualizarContador() {
    const contador = document.getElementById('contador-actividades');
    contador.textContent = `Actividades agregadas: ${contadorActividades}`;
}

function mostrarMensajeVacio() {
    const mensajeVacio = document.getElementById('actividades-vacios');
    const container = document.getElementById('actividades-container');
    
    if (contadorActividades === 0) {
        mensajeVacio.style.display = 'block';
    } else {
        mensajeVacio.style.display = 'none';
    }
}

function mostrarAlerta(mensaje, tipo) {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const cardHeader = document.querySelector('.card-header.bg-light');
    cardHeader.parentNode.insertBefore(alerta, cardHeader.nextSibling);
    
    setTimeout(() => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    }, 5000);
}

// Validación del formulario
document.getElementById('solicitudForm').addEventListener('submit', function(e) {
    const tipoSolicitudSelect = document.getElementById('tipo_solicitud_id');
    const tipoSeleccionado = tipoSolicitudesData.find(tipo => tipo.id == tipoSolicitudSelect.value);
    const equipoSelect = document.getElementById('equipo_id');
    const actividadesSection = document.getElementById('actividades-section');
    
    // Validar equipo para reparación
    if (tipoSeleccionado && tipoSeleccionado.nombre.toLowerCase().includes('reparación')) {
        if (!equipoSelect.value) {
            e.preventDefault();
            mostrarAlerta('Para solicitudes de reparación debe seleccionar un equipo.', 'danger');
            equipoSelect.focus();
            return false;
        }
    }
    
    // Validar actividades solo si la sección de actividades está visible
    if (actividadesSection.style.display !== 'none' && contadorActividades === 0) {
        e.preventDefault();
        mostrarAlerta('Debe agregar al menos una actividad', 'danger');
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
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.25rem;
    }
    
    .card-header.bg-warning {
        background-color: #fff3cd !important;
    }
    
    .actividad-seleccionada {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .actividad-seleccionada:hover {
        background-color: #e9ecef;
    }
    
    .alert {
        margin-bottom: 1rem;
    }
</style>
@endpush