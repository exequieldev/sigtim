<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ComponenteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('equipos.index');
});

Route::resource('equipos', EquipoController::class);

Route::resource('proveedores', ProveedorController::class);

Route::resource('programas', ProgramaController::class);

Route::resource('actividades', ActividadController::class);

Route::resource('departamentos', DepartamentoController::class);

Route::resource('oficinas', OficinaController::class);

Route::resource('empleados', EmpleadoController::class);

Route::resource('componentes', ComponenteController::class);

Route::resource('solicitudes', SolicitudController::class);

Route::get('/reportes/equipos', [EquipoController::class, 'reportes'])
    ->name('equipos.reportes');

Route::get('/estadisticas/equipos', [EquipoController::class, 'estadisticas'])
    ->name('equipos.estadisticas');