@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Editar Empleado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('empleados.update', $empleado) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" 
                                       value="{{ old('nombre', $empleado->nombre) }}" 
                                       placeholder="Ingrese el nombre del empleado" 
                                       required
                                       maxlength="255">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                                       id="apellido" name="apellido" 
                                       value="{{ old('apellido', $empleado->apellido) }}" 
                                       placeholder="Ingrese el apellido del empleado" 
                                       required
                                       maxlength="255">
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $empleado->email) }}" 
                                       placeholder="Ingrese el email del empleado" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" name="telefono" 
                                       value="{{ old('telefono', $empleado->telefono) }}" 
                                       placeholder="Ingrese el teléfono del empleado"
                                       maxlength="20">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cargo" class="form-label">Cargo *</label>
                                <input type="text" class="form-control @error('cargo') is-invalid @enderror" 
                                       id="cargo" name="cargo" 
                                       value="{{ old('cargo', $empleado->cargo) }}" 
                                       placeholder="Ingrese el cargo del empleado" 
                                       required
                                       maxlength="255">
                                @error('cargo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="oficina_id" class="form-label">Oficina *</label>
                                <select class="form-select @error('oficina_id') is-invalid @enderror" 
                                        id="oficina_id" name="oficina_id" required>
                                    <option value="">Seleccionar oficina</option>
                                    @foreach($oficinas as $oficina)
                                        <option value="{{ $oficina->id }}" {{ old('oficina_id', $empleado->oficina_id) == $oficina->id ? 'selected' : '' }}>
                                            {{ $oficina->nombre }} - {{ $oficina->departamento->nombre ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('oficina_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('empleados.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection