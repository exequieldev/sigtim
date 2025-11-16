@extends('layouts.app')

@section('title', 'Crear Oficina')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Crear Nueva Oficina</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('oficinas.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Oficina *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       placeholder="Ingrese el nombre de la oficina" 
                                       required
                                       maxlength="255">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="departamento_id" class="form-label">Departamento *</label>
                                <select class="form-select @error('departamento_id') is-invalid @enderror" 
                                        id="departamento_id" name="departamento_id" required>
                                    <option value="">Seleccionar departamento</option>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                            {{ $departamento->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departamento_id')
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
                                          rows="4" 
                                          placeholder="Describa las funciones y características de la oficina">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('oficinas.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Oficina
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection