@extends('layouts.app')

@section('title', 'Registrar Nuevo Proveedor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Registrar Nuevo Proveedor</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('proveedores.store') }}" method="POST">
                    @csrf
                    
                    <!-- Información Básica -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">Razón Social *</label>
                                <input type="text" class="form-control @error('razon_social') is-invalid @enderror" 
                                       id="razon_social" name="razon_social" 
                                       value="{{ old('razon_social') }}" 
                                       placeholder="Ingrese la razón social" required>
                                @error('razon_social')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cuit" class="form-label">CUIT *</label>
                                <input type="text" class="form-control @error('cuit') is-invalid @enderror" 
                                       id="cuit" name="cuit" 
                                       value="{{ old('cuit') }}" 
                                       placeholder="XX-XXXXXXXX-X" 
                                       maxlength="13" required>
                                @error('cuit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_servicio_id" class="form-label">Tipo de Servicio *</label>
                                <select class="form-select @error('tipo_servicio_id') is-invalid @enderror" 
                                        id="tipo_servicio_id" name="tipo_servicio_id" required>
                                    <option value="">Seleccionar tipo de servicio</option>
                                    @foreach($tiposServicio as $tipo)
                                        <option value="{{ $tipo->id }}" 
                                            {{ old('tipo_servicio_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_servicio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" name="estado" required>
                                    <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto (Opcional) -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Información de Contacto</h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contacto" class="form-label">Persona de Contacto</label>
                                <input type="text" class="form-control @error('contacto') is-invalid @enderror" 
                                       id="contacto" name="contacto" 
                                       value="{{ old('contacto') }}" 
                                       placeholder="Nombre del contacto principal">
                                @error('contacto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" name="telefono" 
                                       value="{{ old('telefono') }}" 
                                       placeholder="Número de teléfono">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="correo@ejemplo.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                          id="direccion" name="direccion" 
                                          rows="3" 
                                          placeholder="Dirección completa del proveedor">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Tipos de Componente -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Tipos de Componente</h6>
                                </div>
                                <div class="card-body">
                                    <div id="tipos-componente-container">
                                        <!-- Primer tipo de componente -->
                                        <div class="tipo-componente-item border-bottom pb-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tipo de Componente</label>
                                                        <select class="form-select @error('tipos_componente.0.tipo_componente_id') is-invalid @enderror" 
                                                                name="tipos_componente[0][tipo_componente_id]">
                                                            <option value="">Seleccionar tipo de componente</option>
                                                            @foreach($tiposComponente as $tipo)
                                                                <option value="{{ $tipo->id }}" 
                                                                    {{ old('tipos_componente.0.tipo_componente_id') == $tipo->id ? 'selected' : '' }}>
                                                                    {{ $tipo->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('tipos_componente.0.tipo_componente_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoComponente(this)" style="margin-top: 8px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-success btn-sm" onclick="agregarTipoComponente()">
                                            <i class="fas fa-plus"></i> Agregar Tipo de Componente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Tipos de Equipo -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">Tipos de Equipo</h6>
                                </div>
                                <div class="card-body">
                                    <div id="tipos-equipo-container">
                                        <!-- Primer tipo de equipo -->
                                        <div class="tipo-equipo-item border-bottom pb-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tipo de Equipo</label>
                                                        <select class="form-select @error('tipos_equipo.0.tipo_equipo_id') is-invalid @enderror" 
                                                                name="tipos_equipo[0][tipo_equipo_id]">
                                                            <option value="">Seleccionar tipo de equipo</option>
                                                            @foreach($tiposEquipo as $tipo)
                                                                <option value="{{ $tipo->id }}" 
                                                                    {{ old('tipos_equipo.0.tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>
                                                                    {{ $tipo->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('tipos_equipo.0.tipo_equipo_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoEquipo(this)" style="margin-top: 8px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-success btn-sm" onclick="agregarTipoEquipo()">
                                            <i class="fas fa-plus"></i> Agregar Tipo de Equipo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Proveedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Variables para contar cada tipo
let contadorTiposComponente = 1;
let contadorTiposEquipo = 1;


// Funciones para Tipos de Componente
function agregarTipoComponente() {
    const container = document.getElementById('tipos-componente-container');
    
    const nuevoTipoComponente = document.createElement('div');
    nuevoTipoComponente.className = 'tipo-componente-item border-bottom pb-3 mb-3';
    nuevoTipoComponente.innerHTML = `
        <div class="row">
            <div class="col-md-11">
                <div class="mb-3">
                    <label class="form-label">Tipo de Componente</label>
                    <select class="form-select" name="tipos_componente[${contadorTiposComponente}][tipo_componente_id]">
                        <option value="">Seleccionar tipo de componente</option>
                        @foreach($tiposComponente as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoComponente(this)" style="margin-top: 8px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoTipoComponente);
    contadorTiposComponente++;
}

function eliminarTipoComponente(boton) {
    const item = boton.closest('.tipo-componente-item');
    const container = document.getElementById('tipos-componente-container');
    
    if (container.children.length > 1) {
        item.remove();
    } else {
        alert('Debe haber al menos un tipo de componente');
    }
}

// Funciones para Tipos de Equipo
function agregarTipoEquipo() {
    const container = document.getElementById('tipos-equipo-container');
    
    const nuevoTipoEquipo = document.createElement('div');
    nuevoTipoEquipo.className = 'tipo-equipo-item border-bottom pb-3 mb-3';
    nuevoTipoEquipo.innerHTML = `
        <div class="row">
            <div class="col-md-11">
                <div class="mb-3">
                    <label class="form-label">Tipo de Equipo</label>
                    <select class="form-select" name="tipos_equipo[${contadorTiposEquipo}][tipo_equipo_id]">
                        <option value="">Seleccionar tipo de equipo</option>
                        @foreach($tiposEquipo as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTipoEquipo(this)" style="margin-top: 8px;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoTipoEquipo);
    contadorTiposEquipo++;
}

function eliminarTipoEquipo(boton) {
    const item = boton.closest('.tipo-equipo-item');
    const container = document.getElementById('tipos-equipo-container');
    
    if (container.children.length > 1) {
        item.remove();
    } else {
        alert('Debe haber al menos un tipo de equipo');
    }
}


function eliminarTipoAccesorio(boton) {
    const item = boton.closest('.tipo-accesorio-item');
    const container = document.getElementById('tipos-accesorio-container');
    
    if (container.children.length > 1) {
        item.remove();
    } else {
        alert('Debe haber al menos un tipo de accesorio');
    }
}

// Formatear CUIT automáticamente
document.addEventListener('DOMContentLoaded', function() {
    const cuitInput = document.getElementById('cuit');
    
    cuitInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 2) {
            value = value.substring(0, 2) + '-' + value.substring(2);
        }
        if (value.length > 11) {
            value = value.substring(0, 11) + '-' + value.substring(11, 12);
        }
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        
        e.target.value = value;
    });
});
</script>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .border-bottom {
        border-color: #dee2e6 !important;
    }
</style>
@endpush