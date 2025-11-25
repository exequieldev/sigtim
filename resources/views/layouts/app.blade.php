<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SGTIM'))</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('css')
    
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #4895ef;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --dark-color: #2b2d42;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Layout Principal */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-color) 0%, #1a1c2e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        
        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            visibility: hidden;
        }
        
        /* Brand Section */
        .brand-section {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .brand-text {
            font-weight: 800;
            font-size: 1.5rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
        }
        
        .brand-text i {
            color: var(--accent-color);
        }
        
        /* Navigation */
        .sidebar-nav {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }
        
        .nav-item {
            margin: 5px 15px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .nav-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }
        
        .nav-link[aria-expanded="true"] .nav-arrow {
            transform: rotate(180deg);
        }
        
        /* Submenu Styles */
        .nav-submenu {
            list-style: none;
            padding: 0;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            margin: 5px 0;
            overflow: hidden;
        }
        
        .nav-submenu .nav-link {
            padding: 10px 15px 10px 45px;
            font-size: 0.9rem;
            border-radius: 0;
        }
        
        .nav-submenu .nav-link i {
            font-size: 0.8rem;
            width: 16px;
        }
        
        .nav-submenu .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: var(--accent-color);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .navbar-toggler {
            border: none;
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Content */
        .content {
            padding: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -100%;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        {{-- Sidebar --}}
        <aside class="sidebar" id="sidebar">
            <!-- Brand Section -->
            <div class="brand-section">
                <a href="{{ url('/') }}" class="brand-text">
                    <i class="fas fa-cube"></i>
                    <span class="sidebar-text">SGTIM</span>
                </a>
            </div>

            <!-- Sidebar Menu COMPLETO - CONSERVANDO EXACTAMENTE LO QUE PEDISTE -->
            <nav class="sidebar-nav mt-2">
                <ul class="nav flex-column">                    
                    <!-- Opción 2: Dashboard -->
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- Opción 3: Solicitudes -->
                    <li class="nav-item">
                        <a href="{{ url('solicitudes') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span class="sidebar-text">Solicitudes</span>
                        </a>
                    </li>

                    <!-- Opción 4: Oficinas - Menú desplegable -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#oficinasMenu" 
                           role="button" aria-expanded="false" aria-controls="oficinasMenu">
                            <i class="far fa-building"></i>
                            <span class="sidebar-text">Oficinas</span>
                            <i class="nav-arrow fas fa-angle-down"></i>
                        </a>
                        <div class="collapse nav-submenu" id="oficinasMenu">
                            <a href="{{ url('departamentos') }}" class="nav-link">
                                <i class="fas fa-sitemap"></i>
                                <span class="sidebar-text">Departamentos</span>
                            </a>
                            <a href="{{ url('oficinas') }}" class="nav-link">
                                <i class="fas fa-building"></i>
                                <span class="sidebar-text">Oficinas</span>
                            </a>
                            <a href="{{ url('empleados') }}" class="nav-link">
                                <i class="fas fa-users"></i>
                                <span class="sidebar-text">Empleados</span>
                            </a>
                        </div>
                    </li>
                    
                    <!-- Opción 5: Actividades - CONSERVANDO EXACTAMENTE COMO PEDISTE -->
                    <li class="nav-item">
                        <a href="{{ url('actividades') }}" class="nav-link @yield('actividades-active')">
                            <i class="fas fa-tasks"></i>
                            <span class="sidebar-text">Actividades</span>
                        </a>
                    </li>

                    <!-- Opción 6: Programas -->
                    <li class="nav-item">
                        <a href="{{ url('programas') }}" class="nav-link">
                            <i class="fas fa-code"></i>
                            <span class="sidebar-text">Programas</span>
                        </a>
                    </li>

                    <!-- Opción 7: Equipos -->
                    <li class="nav-item">
                        <a href="{{ url('equipos') }}" class="nav-link">
                            <i class="fas fa-laptop"></i>
                            <span class="sidebar-text">Equipos</span>
                        </a>
                    </li>

                    <!-- Opción 8: Accesorios -->
                    <li class="nav-item">
                        <a href="admin/settings" class="nav-link">
                            <i class="fas fa-keyboard"></i>
                            <span class="sidebar-text">Accesorios</span>
                        </a>
                    </li>

                    <!-- Opción 9: Componentes -->
                    <li class="nav-item">
                        <a href="{{ url('componentes') }}" class="nav-link">
                            <i class="fas fa-microchip"></i>
                            <span class="sidebar-text">Componentes</span>
                        </a>
                    </li>

                    <!-- Opción 10: Proveedores -->
                    <li class="nav-item">
                        <a href="{{ url('proveedores') }}" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span class="sidebar-text">Proveedores</span>
                        </a>
                    </li>

                    <!-- Opción 11: Mantenimiento - Menú desplegable -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#mantenimientoMenu" 
                           role="button" aria-expanded="false" aria-controls="mantenimientoMenu">
                            <i class="fas fa-tools"></i>
                            <span class="sidebar-text">Mantenimiento</span>
                            <i class="nav-arrow fas fa-angle-down"></i>
                        </a>
                        <div class="collapse nav-submenu" id="mantenimientoMenu">
                            <a href="{{ url('diagnosticos') }}" class="nav-link">
                                <i class="fas fa-stethoscope"></i>
                                <span class="sidebar-text">Diagnóstico</span>
                            </a>
                            <a href="#" class="nav-link">
                                <i class="fas fa-wrench"></i>
                                <span class="sidebar-text">Reparación</span>
                            </a>
                        </div>
                    </li>

                    <!-- Opción 12: Configuración - Menú desplegable -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#configMenu" 
                           role="button" aria-expanded="false" aria-controls="configMenu">
                            <i class="fas fa-cog"></i>
                            <span class="sidebar-text">Configuración</span>
                            <i class="nav-arrow fas fa-angle-down"></i>
                        </a>
                        <div class="collapse nav-submenu" id="configMenu">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user-cog"></i>
                                <span class="sidebar-text">level_one</span>
                            </a>
                            <a href="#" class="nav-link">
                                <i class="fas fa-sliders-h"></i>
                                <span class="sidebar-text">level_one</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="main-content" id="mainContent">
            {{-- Top Navbar --}}
            <nav class="top-navbar">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <button class="navbar-toggler me-3" id="sidebarToggle">
                                <i class="fas fa-bars"></i>
                            </button>
                            <!-- <h4 class="mb-0">@yield('page-title', 'Sistema de Gestión')</h4> -->
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                    <span class="fw-bold">Usuario</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i> Perfil
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-cog me-2"></i> Configuración
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Content --}}
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
    
    <script>
        // =============================================
        // FUNCIÓN 1: Toggle Sidebar
        // =============================================
        function initSidebarToggle() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        }

        // =============================================
        // FUNCIÓN 2: Inicializar todos los collapsibles
        // =============================================
        function initAllCollapsibles() {
            // Todos los menús desplegables funcionan automáticamente con Bootstrap
            // Solo necesitamos asegurarnos de que los eventos se manejen correctamente
            
            const collapsibles = document.querySelectorAll('.collapse');
            
            collapsibles.forEach(collapse => {
                collapse.addEventListener('show.bs.collapse', function() {
                    console.log('Menú abierto:', this.id);
                });
                
                collapse.addEventListener('hide.bs.collapse', function() {
                    console.log('Menú cerrado:', this.id);
                });
            });
        }

        // =============================================
        // FUNCIÓN 3: Manejo responsive para móviles
        // =============================================
        function initMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 768) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                
                // Cerrar sidebar al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        }

        // =============================================
        // INICIALIZAR TODO
        // =============================================
        document.addEventListener('DOMContentLoaded', function() {
            initSidebarToggle();
            initAllCollapsibles();
            initMobileMenu();
        });
    </script>

    @yield('js')
</body>
</html>