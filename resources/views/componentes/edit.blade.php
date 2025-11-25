@extends('layouts.app')

@section('title', 'Editar Componente')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Componente - {{ $componente->modelo }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('componentes.update', $componente) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Tipo de Componente -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_componente_id">Tipo de Componente *</label>
                                <select name="tipo_componente_id" id="tipo_componente_id" class="form-control @error('tipo_componente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tiposComponente as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('tipo_componente_id', $componente->tipo_componente_id) == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_componente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fabricante -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fabricante_id">Fabricante *</label>
                                <select name="fabricante_id" id="fabricante_id" class="form-control @error('fabricante_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un fabricante</option>
                                    @foreach($fabricantes as $fabricante)
                                        <option value="{{ $fabricante->id }}" {{ old('fabricante_id', $componente->fabricante_id) == $fabricante->id ? 'selected' : '' }}>
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
                        <!-- Modelo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modelo">Modelo *</label>
                                <input type="text" name="modelo" id="modelo" 
                                       class="form-control @error('modelo') is-invalid @enderror" 
                                       value="{{ old('modelo', $componente->modelo) }}" 
                                       placeholder="Ingrese el modelo del componente" required>
                                @error('modelo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Número de Serie -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero_serie">Número de Serie</label>
                                <input type="text" name="numero_serie" id="numero_serie" 
                                       class="form-control @error('numero_serie') is-invalid @enderror" 
                                       value="{{ old('numero_serie', $componente->numero_serie) }}" 
                                       placeholder="Ingrese el número de serie">
                                @error('numero_serie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Especificaciones -->
                    <div class="form-group">
                        <label for="especificaciones">Especificaciones</label>
                        <textarea name="especificaciones" id="especificaciones" 
                                  class="form-control @error('especificaciones') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="Ingrese las especificaciones técnicas del componente">{{ old('especificaciones', $componente->especificaciones) }}</textarea>
                        @error('especificaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Fecha de Adquisición -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_adquisicion">Fecha de Adquisición *</label>
                                <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" 
                                       class="form-control @error('fecha_adquisicion') is-invalid @enderror" 
                                       value="{{ old('fecha_adquisicion', $componente->fecha_adquisicion->format('Y-m-d')) }}" required>
                                @error('fecha_adquisicion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha de Instalación -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_instalacion">Fecha de Instalación</label>
                                <input type="date" name="fecha_instalacion" id="fecha_instalacion" 
                                       class="form-control @error('fecha_instalacion') is-invalid @enderror" 
                                       value="{{ old('fecha_instalacion', $componente->fecha_instalacion ? $componente->fecha_instalacion->format('Y-m-d') : '') }}">
                                @error('fecha_instalacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Componente
                        </button>
                        <a href="{{ route('componentes.show', $componente) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <a href="{{ route('componentes.index') }}" class="btn btn-outline-dark">
                            <i class="fas fa-list"></i> Volver al Listado
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Validación para fecha_instalacion no sea anterior a fecha_adquisicion
        $('#fecha_instalacion').change(function() {
            const fechaAdquisicion = $('#fecha_adquisicion').val();
            const fechaInstalacion = $(this).val();
            
            if (fechaInstalacion && fechaAdquisicion && fechaInstalacion < fechaAdquisicion) {
                alert('La fecha de instalación no puede ser anterior a la fecha de adquisición');
                $(this).val('');
            }
        });

        // Inicializar select2 si está disponible
        if ($.fn.select2) {
            $('#tipo_componente_id, #fabricante_id').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        }
    });
</script>
@endsection