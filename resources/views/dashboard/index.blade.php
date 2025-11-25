@extends('layouts.app')

@section('title', 'Dashboard - SGTIM')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                        Vista General
                    </h4>
                    <p class="text-muted mb-0">TABLERO PRINCIPAL</p>
                </div>
                <div class="page-title-right">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt me-1"></i>Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="text-primary mb-1">2,556</h3>
                            <p class="text-muted mb-0">Activos Totales</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle p-2 text-white">
                                <i class="fas fa-server"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="text-info mb-1">15,154</h3>
                            <p class="text-muted mb-0">Software</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-info rounded-circle p-2 text-white">
                                <i class="fas fa-code"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="text-success mb-1">1</h3>
                            <p class="text-muted mb-0">Nuevos Dispositivos</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle p-2 text-white">
                                <i class="fas fa-laptop"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="text-warning mb-1">867</h3>
                            <p class="text-muted mb-0">Dispositivos Inactivos</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle p-2 text-white">
                                <i class="fas fa-eye-slash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="row">
        <!-- Asset Distribution -->
        <div class="col-xl-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        DISTRIBUCIÓN DE ACTIVOS
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="progress-container">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Estaciones de Trabajo</span>
                                    <span class="fw-bold">1,244</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 48%"></div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Servidores</span>
                                    <span class="fw-bold">233</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 9%"></div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Laptops</span>
                                    <span class="fw-bold">257</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 10%"></div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Dispositivos Móviles</span>
                                    <span class="fw-bold">180</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 7%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="distribution-chart-placeholder">
                                <i class="fas fa-chart-pie fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Visualización de distribución</p>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-around">
                                        <div>
                                            <div class="fw-bold text-primary">48%</div>
                                            <small class="text-muted">Estaciones</small>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-info">9%</div>
                                            <small class="text-muted">Servidores</small>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success">10%</div>
                                            <small class="text-muted">Laptops</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Audits -->
        <div class="col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-shield-alt me-2 text-warning"></i>
                        AUDITORÍAS DE SEGURIDAD
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fab fa-adobe text-danger me-2"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Adobe Acrobat Reader</h6>
                                    <small class="text-muted">Agosto 2023 • 15 vulnerabilidades</small>
                                </div>
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-firewall text-primary me-2"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Fortinet CVE-2023-33308</h6>
                                    <small class="text-muted">Parche de seguridad crítico</small>
                                </div>
                                <span class="badge bg-danger">Urgente</span>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fab fa-linux text-warning me-2"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Linux BleedingTooth</h6>
                                    <small class="text-muted">Actualización del kernel</small>
                                </div>
                                <span class="badge bg-warning text-dark">Alta</span>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-plus text-muted me-2"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Ver más auditorías</h6>
                                    <small class="text-muted">12 auditorías adicionales</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-list-alt me-2 text-success"></i>
                        ACTIVIDAD RECIENTE
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Dispositivo</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Última Actividad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">PC-ADMIN-01</div>
                                        <small class="text-muted">192.168.1.100</small>
                                    </td>
                                    <td><span class="badge bg-primary">Workstation</span></td>
                                    <td><span class="badge bg-success">Online</span></td>
                                    <td>Hace 5 min</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">SRV-FILE-01</div>
                                        <small class="text-muted">192.168.1.10</small>
                                    </td>
                                    <td><span class="badge bg-info">Server</span></td>
                                    <td><span class="badge bg-success">Online</span></td>
                                    <td>Hace 12 min</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">SW-CORE-01</div>
                                        <small class="text-muted">192.168.1.1</small>
                                    </td>
                                    <td><span class="badge bg-warning">Network</span></td>
                                    <td><span class="badge bg-danger">Offline</span></td>
                                    <td>Hace 2 horas</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection