@extends('layouts.app')

@section('title', 'Nuevo Diagnóstico')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nuevo Diagnóstico Automático</h5>
                    <p class="text-muted mb-0">Solicitud #{{ $datosPredeterminados['solicitud_id'] }} - Equipo asignado automáticamente</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('diagnosticos.store') }}" method="POST" id="diagnosticoForm">
                        @csrf
                        
                        <!-- Campos ocultos para la solicitud y equipo -->
                        <input type="hidden" name="solicitud_id" value="{{ $datosPredeterminados['solicitud_id'] }}">
                        <input type="hidden" name="equipo_id" value="{{ $datosPredeterminados['equipo_id'] }}">
                        
                        <!-- Información de la solicitud -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">📝 Información de la Solicitud</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Número de Solicitud</label>
                                            <input type="text" class="form-control bg-light" value="Solicitud #{{ $datosPredeterminados['solicitud_id'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Empleado</label>
                                            <input type="text" class="form-control bg-light" value="{{ $datosPredeterminados['empleado_solicitud'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Solicitud</label>
                                            <input type="text" class="form-control bg-light" value="{{ $solicitud->tipoSolicitud->nombre ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del equipo -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">📋 Información del Equipo a Diagnosticar</h6>
                            </div>
                            <div class="card-body">
                                <!-- Mostrar información del equipo asignado -->
                                <div class="alert alert-info">
                                    <h6>Equipo asignado para diagnóstico:</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Número de Serie:</strong><br>
                                            {{ $equipoSeleccionado->numero_serie ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Modelo:</strong><br>
                                            {{ $equipoSeleccionado->modelo ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Marca:</strong><br>
                                            {{ $equipoSeleccionado->marca ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Tipo:</strong><br>
                                            {{ $equipoSeleccionado->tipoEquipo->nombre ?? 'N/A' }}
                                        </div>
                                    </div>
                                    @if($equipoSeleccionado->descripcion)
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <strong>Descripción:</strong><br>
                                            {{ $equipoSeleccionado->descripcion }}
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tipo_equipo" class="form-label">Tipo de Equipo *</label>
                                            <select class="form-select @error('tipo_equipo') is-invalid @enderror" 
                                                    id="tipo_equipo" name="tipo_equipo" required>
                                                <option value="">Seleccione tipo de equipo</option>
                                                @foreach(App\Models\Diagnostico::TIPOS_EQUIPO as $key => $value)
                                                    <option value="{{ $key }}" {{ old('tipo_equipo', $datosPredeterminados['tipo_equipo']) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tipo_equipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="marca_equipo" class="form-label">Marca</label>
                                            <input type="text" class="form-control @error('marca_equipo') is-invalid @enderror" 
                                                   id="marca_equipo" name="marca_equipo" 
                                                   value="{{ old('marca_equipo', $datosPredeterminados['marca_equipo']) }}">
                                            @error('marca_equipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="modelo_equipo" class="form-label">Modelo</label>
                                            <input type="text" class="form-control @error('modelo_equipo') is-invalid @enderror" 
                                                   id="modelo_equipo" name="modelo_equipo" 
                                                   value="{{ old('modelo_equipo', $datosPredeterminados['modelo_equipo']) }}">
                                            @error('modelo_equipo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="numero_serie" class="form-label">Número de Serie</label>
                                            <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
                                                   id="numero_serie" name="numero_serie" 
                                                   value="{{ old('numero_serie', $datosPredeterminados['numero_serie']) }}">
                                            @error('numero_serie')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edificio" class="form-label">Edificio *</label>
                                            <input type="text" class="form-control @error('edificio') is-invalid @enderror" 
                                                   id="edificio" name="edificio" 
                                                   value="{{ old('edificio', $datosPredeterminados['edificio']) }}" required>
                                            @error('edificio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="piso" class="form-label">Piso *</label>
                                            <input type="text" class="form-control @error('piso') is-invalid @enderror" 
                                                   id="piso" name="piso" 
                                                   value="{{ old('piso', $datosPredeterminados['piso']) }}" required>
                                            @error('piso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="oficina" class="form-label">Oficina *</label>
                                            <input type="text" class="form-control @error('oficina') is-invalid @enderror" 
                                                   id="oficina" name="oficina" 
                                                   value="{{ old('oficina', $datosPredeterminados['oficina']) }}" required>
                                            @error('oficina')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Componentes del equipo -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">🔧 Componentes del Equipo</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Seleccione el estado de cada componente. El diagnóstico se generará automáticamente.</p>
                                
                                @if($componentesReales->isNotEmpty())
                                <div id="componentes-lista">
                                    <div class="alert alert-success mb-4">
                                        <h6><i class="fas fa-microchip"></i> Componentes Reales del Equipo:</h6>
                                        <p class="mb-2">Se han encontrado <strong>{{ $componentesReales->count() }} componentes</strong> registrados en el sistema.</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="40%">Componente</th>
                                                            <th width="15%">Importancia</th>
                                                            <th width="15%">Buen Estado</th>
                                                            <th width="15%">Defectuoso</th>
                                                            <th width="15%">No Verificado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($componentesReales as $index => $componente)
                                                        <tr data-componente='@json($componente)'>
                                                            <td>
                                                                <strong>{{ $componente['nombre'] }}</strong>
                                                                <br>
                                                                <small class="text-muted">
                                                                    Tipo: {{ $componente['tipo'] }}
                                                                    @if($componente['modelo'])
                                                                    | Modelo: {{ $componente['modelo'] }}
                                                                    @endif
                                                                    @if($componente['fabricante'] != 'N/A')
                                                                    | Fabricante: {{ $componente['fabricante'] }}
                                                                    @endif
                                                                </small>
                                                                @if($componente['especificaciones'])
                                                                <br>
                                                                <small class="text-muted">
                                                                    Especificaciones: {{ Str::limit($componente['especificaciones'], 50) }}
                                                                </small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-{{ $componente['importancia_class'] }}">{{ $componente['importancia_text'] }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="radio" name="estado_{{ $index }}" value="good" 
                                                                       class="btn-check estado-componente" 
                                                                       id="good_{{ $index }}" autocomplete="off"
                                                                       onchange="actualizarDiagnostico()">
                                                                <label class="btn btn-outline-success btn-sm" for="good_{{ $index }}">
                                                                    <i class="fas fa-check"></i>
                                                                </label>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="radio" name="estado_{{ $index }}" value="faulty" 
                                                                       class="btn-check estado-componente" 
                                                                       id="faulty_{{ $index }}" autocomplete="off"
                                                                       onchange="actualizarDiagnostico()">
                                                                <label class="btn btn-outline-danger btn-sm" for="faulty_{{ $index }}">
                                                                    <i class="fas fa-times"></i>
                                                                </label>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="radio" name="estado_{{ $index }}" value="unknown" 
                                                                       class="btn-check estado-componente" 
                                                                       id="unknown_{{ $index }}" autocomplete="off" checked
                                                                       onchange="actualizarDiagnostico()">
                                                                <label class="btn btn-outline-warning btn-sm" for="unknown_{{ $index }}">
                                                                    <i class="fas fa-question"></i>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div id="componentes-lista">
                                    <div class="alert alert-warning">
                                        <h6><i class="fas fa-exclamation-triangle"></i> No hay componentes registrados</h6>
                                        <p class="mb-0">
                                            Este equipo no tiene componentes específicos registrados en el sistema. 
                                            No se puede realizar el diagnóstico automático sin componentes.
                                        </p>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Campos ocultos para almacenar los datos -->
                                <input type="hidden" id="componentes_estado" name="componentes_estado" value="{{ old('componentes_estado', '[]') }}">
                                <input type="hidden" id="componentes_defectuosos" name="componentes_defectuosos" value="{{ old('componentes_defectuosos', '[]') }}">
                                <input type="hidden" id="recursos_necesarios" name="recursos_necesarios" value="{{ old('recursos_necesarios', '[]') }}">
                            </div>
                        </div>

                        <!-- Diagnóstico automático -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">🔍 Diagnóstico Automático</h6>
                            </div>
                            <div class="card-body">
                                <div class="card bg-primary text-white mb-3">
                                    <div class="card-body text-center">
                                        <div class="display-4 fw-bold" id="porcentaje-diagnostico">0%</div>
                                        <div class="h5" id="mensaje-diagnostico">Seleccione el estado de los componentes</div>
                                        <div class="progress bg-white bg-opacity-25 mt-3" style="height: 20px;">
                                            <div class="progress-bar bg-white" id="barra-progreso" style="width: 0%"></div>
                                        </div>
                                        <div class="mt-2" id="nivel-gravedad">Gravedad: No determinado</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Análisis Automático</h6>
                                            </div>
                                            <div class="card-body">
                                                <div id="analisis-componentes">No se han analizado componentes aún.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Recomendaciones de Reparación</h6>
                                            </div>
                                            <div class="card-body">
                                                <div id="texto-recomendaciones">Complete el diagnóstico para ver recomendaciones.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Campos ocultos para diagnóstico -->
                                <input type="hidden" id="porcentaje_funcionalidad" name="porcentaje_funcionalidad" value="{{ old('porcentaje_funcionalidad', 0) }}">
                                <input type="hidden" id="nivel_gravedad" name="nivel_gravedad" value="{{ old('nivel_gravedad', 'baja') }}">
                                <input type="hidden" id="mensaje_diagnostico" name="mensaje_diagnostico" value="{{ old('mensaje_diagnostico', '') }}">
                                <input type="hidden" id="analisis_componentes" name="analisis_componentes" value="{{ old('analisis_componentes', '') }}">
                                <input type="hidden" id="recomendaciones" name="recomendaciones" value="{{ old('recomendaciones', '') }}">
                            </div>
                        </div>

                        <!-- Información del técnico -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">👨‍💼 Información del Técnico</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tecnico_responsable" class="form-label">Técnico Responsable *</label>
                                            <input type="text" class="form-control @error('tecnico_responsable') is-invalid @enderror" 
                                                   id="tecnico_responsable" name="tecnico_responsable" 
                                                   value="{{ old('tecnico_responsable', $datosPredeterminados['tecnico_responsable']) }}" required>
                                            @error('tecnico_responsable')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_diagnostico" class="form-label">Fecha del Diagnóstico *</label>
                                            <input type="date" class="form-control @error('fecha_diagnostico') is-invalid @enderror" 
                                                   id="fecha_diagnostico" name="fecha_diagnostico" 
                                                   value="{{ old('fecha_diagnostico', date('Y-m-d')) }}" required>
                                            @error('fecha_diagnostico')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Volver a Solicitudes
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Diagnóstico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Cargar componentes automáticamente cuando la página se carga
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el diagnóstico con los componentes reales
    actualizarDiagnostico();
});

function actualizarDiagnostico() {
    const componentes = [];
    
    // Obtener todas las filas de componentes
    const filasComponentes = document.querySelectorAll('tr[data-componente]');
    
    filasComponentes.forEach((fila, index) => {
        try {
            // Obtener datos del componente desde el atributo data
            const componenteData = JSON.parse(fila.getAttribute('data-componente'));
            
            // Validar que tenga los datos necesarios
            if (!componenteData.nombre || componenteData.peso === undefined) {
                console.warn('Componente sin datos completos:', componenteData);
                return;
            }
            
            // Obtener el estado seleccionado
            const estadoSeleccionado = fila.querySelector('input[type="radio"]:checked');
            const estado = estadoSeleccionado ? estadoSeleccionado.value : 'unknown';
            
            componentes.push({
                nombre: componenteData.nombre,
                peso: componenteData.peso,
                estado: estado
            });
        } catch (error) {
            console.error('Error procesando componente:', error);
        }
    });
    
    const estadosComponentes = [];
    let puntuacionTotal = 0;
    let puntuacionMaxima = 0;
    const componentesDefectuosos = [];
    const recursosNecesarios = [];
    
    componentes.forEach((componente) => {
        estadosComponentes.push({
            nombre: componente.nombre,
            peso: componente.peso,
            estado: componente.estado
        });
        
        puntuacionMaxima += componente.peso;
        
        switch (componente.estado) {
            case 'good':
                puntuacionTotal += componente.peso;
                break;
            case 'faulty':
                componentesDefectuosos.push(componente.nombre);
                // Sugerir recursos basados en el nombre del componente
                if (componente.nombre.toLowerCase().includes('pantalla') || 
                    componente.nombre.toLowerCase().includes('monitor')) {
                    recursosNecesarios.push('Pantalla de reemplazo');
                } else if (componente.nombre.toLowerCase().includes('batería') || 
                          componente.nombre.toLowerCase().includes('bateria')) {
                    recursosNecesarios.push('Batería de reemplazo');
                } else if (componente.nombre.toLowerCase().includes('disco') || 
                          componente.nombre.toLowerCase().includes('almacenamiento')) {
                    recursosNecesarios.push('Disco duro/SSD');
                } else if (componente.nombre.toLowerCase().includes('memoria') || 
                          componente.nombre.toLowerCase().includes('ram')) {
                    recursosNecesarios.push('Módulos de RAM');
                } else if (componente.nombre.toLowerCase().includes('fuente') || 
                          componente.nombre.toLowerCase().includes('poder')) {
                    recursosNecesarios.push('Fuente de poder');
                } else if (componente.nombre.toLowerCase().includes('cargador')) {
                    recursosNecesarios.push('Cargador');
                } else if (componente.nombre.toLowerCase().includes('teclado')) {
                    recursosNecesarios.push('Teclado');
                } else {
                    recursosNecesarios.push(componente.nombre + ' de reemplazo');
                }
                break;
            case 'unknown':
                puntuacionTotal += componente.peso * 0.5;
                break;
        }
    });
    
    const porcentajeFuncional = puntuacionMaxima > 0 ? (puntuacionTotal / puntuacionMaxima) * 100 : 0;
    
    // Determinar nivel de gravedad y mensaje
    let nivelGravedad, mensaje, barraClass;
    if (porcentajeFuncional >= 80) {
        nivelGravedad = 'baja';
        mensaje = '✅ Equipo en buen estado';
        barraClass = 'bg-success';
    } else if (porcentajeFuncional >= 50) {
        nivelGravedad = 'media';
        mensaje = '⚠️ Equipo con problemas menores';
        barraClass = 'bg-warning';
    } else if (porcentajeFuncional >= 20) {
        nivelGravedad = 'alta';
        mensaje = '🔧 Equipo requiere reparación';
        barraClass = 'bg-danger';
    } else {
        nivelGravedad = 'critica';
        mensaje = '🚨 Equipo en estado crítico';
        barraClass = 'bg-dark';
    }
    
    // Actualizar interfaz
    document.getElementById('porcentaje-diagnostico').textContent = `${Math.round(porcentajeFuncional)}%`;
    document.getElementById('mensaje-diagnostico').textContent = mensaje;
    document.getElementById('barra-progreso').style.width = `${porcentajeFuncional}%`;
    document.getElementById('barra-progreso').className = `progress-bar ${barraClass}`;
    document.getElementById('nivel-gravedad').textContent = `Gravedad: ${nivelGravedad.toUpperCase()}`;
    
    // Actualizar análisis
    let analisisHTML = '';
    if (componentesDefectuosos.length > 0) {
        analisisHTML = `
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle"></i> Componentes Defectuosos:</h6>
                <ul>
                    ${componentesDefectuosos.map(comp => `<li>${comp}</li>`).join('')}
                </ul>
            </div>
        `;
    } else {
        analisisHTML = `
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> No se detectaron componentes defectuosos.
            </div>
        `;
    }
    
    analisisHTML += `
        <div class="mt-3">
            <h6>Resumen del Análisis:</h6>
            <p>Se analizaron ${componentes.length} componentes del equipo.</p>
            <p>Funcionalidad general: <strong>${Math.round(porcentajeFuncional)}%</strong></p>
        </div>
    `;
    
    document.getElementById('analisis-componentes').innerHTML = analisisHTML;
    
    // Actualizar recomendaciones
    let recomendacionesHTML = '';
    if (recursosNecesarios.length > 0) {
        recomendacionesHTML = `
            <div class="alert alert-info">
                <h6><i class="fas fa-tools"></i> Recursos Necesarios:</h6>
                <ul>
                    ${recursosNecesarios.map(recurso => `<li>${recurso}</li>`).join('')}
                </ul>
            </div>
        `;
    }
    
    // Agregar recomendaciones generales basadas en el nivel de gravedad
    switch(nivelGravedad) {
        case 'baja':
            recomendacionesHTML += `
                <div class="alert alert-success">
                    <h6><i class="fas fa-thumbs-up"></i> Recomendaciones:</h6>
                    <ul>
                        <li>Mantenimiento preventivo rutinario</li>
                        <li>Limpieza general del equipo</li>
                        <li>Verificación de actualizaciones de software</li>
                    </ul>
                </div>
            `;
            break;
        case 'media':
            recomendacionesHTML += `
                <div class="alert alert-warning">
                    <h6><i class="fas fa-wrench"></i> Recomendaciones:</h6>
                    <ul>
                        <li>Reparación de componentes específicos</li>
                        <li>Reemplazo de piezas desgastadas</li>
                        <li>Diagnóstico más detallado</li>
                    </ul>
                </div>
            `;
            break;
        case 'alta':
            recomendacionesHTML += `
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-circle"></i> Recomendaciones:</h6>
                    <ul>
                        <li>Reparación urgente requerida</li>
                        <li>Posible reemplazo de componentes críticos</li>
                        <li>Evaluación de costo-beneficio</li>
                    </ul>
                </div>
            `;
            break;
        case 'critica':
            recomendacionesHTML += `
                <div class="alert alert-dark">
                    <h6><i class="fas fa-skull-crossbones"></i> Recomendaciones:</h6>
                    <ul>
                        <li>Equipo posiblemente irreparable</li>
                        <li>Considerar reemplazo completo</li>
                        <li>Recuperación de datos si es necesario</li>
                    </ul>
                </div>
            `;
            break;
    }
    
    document.getElementById('texto-recomendaciones').innerHTML = recomendacionesHTML;
    
    // Actualizar campos ocultos del formulario
    document.getElementById('componentes_estado').value = JSON.stringify(estadosComponentes);
    document.getElementById('componentes_defectuosos').value = JSON.stringify(componentesDefectuosos);
    document.getElementById('recursos_necesarios').value = JSON.stringify(recursosNecesarios);
    document.getElementById('porcentaje_funcionalidad').value = porcentajeFuncional;
    document.getElementById('nivel_gravedad').value = nivelGravedad;
    document.getElementById('mensaje_diagnostico').value = mensaje;
    document.getElementById('analisis_componentes').value = analisisHTML;
    document.getElementById('recomendaciones').value = recomendacionesHTML;
}
</script>
@endpush