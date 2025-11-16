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
                                        id="tipo_solicitud_id" name="tipo_solicitud_id" required>
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

                    <!-- Sección de Actividades Asociadas -->
                    <div class="row mt-4">
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

// Inicializar el contador
document.addEventListener('DOMContentLoaded', function() {
    actualizarContador();
    mostrarMensajeVacio();
});

function agregarActividadDesdeSelect() {
    const select = document.getElementById('actividadSelect');
    const actividadId = select.value;
    
    if (!actividadId) {
        mostrarAlerta('Por favor selecciona una actividad', 'warning');
        return;
    }
    
    // Verificar si la actividad ya fue agregada
    if (actividadesAgregadas.has(actividadId)) {
        mostrarAlerta('Esta actividad ya ha sido agregada', 'warning');
        return;
    }
    
    const option = select.options[select.selectedIndex];
    const nombre = option.getAttribute('data-nombre');
    
    // Crear elemento de la actividad seleccionada
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
    
    // Resetear select
    select.selectedIndex = 0;
    
    // Actualizar interfaz
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
    
    // Actualizar interfaz
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
    // Crear alerta temporal
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insertar después del título de actividades
    const cardHeader = document.querySelector('.card-header.bg-light');
    cardHeader.parentNode.insertBefore(alerta, cardHeader.nextSibling);
    
    // Auto-eliminar después de 3 segundos
    setTimeout(() => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    }, 3000);
}

// Validación del formulario
document.getElementById('solicitudForm').addEventListener('submit', function(e) {
    if (contadorActividades === 0) {
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
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.25rem;
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