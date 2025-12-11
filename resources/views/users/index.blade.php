<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        .sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }
        
        .active-nav {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #3b82f6;
        }
        
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .status-active {
            background-color: #10b981;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .status-inactive {
            background-color: #ef4444;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .status-pending {
            background-color: #f59e0b;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Contenedor principal -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-64 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users-cog text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold">AdminPanel</h1>
                </div>
            </div>
            
            <!-- Menú de navegación -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="/dashboard" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users" class="flex items-center p-3 rounded-lg active-nav">
                            <i class="fas fa-users mr-3"></i>
                            Gestión de Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="/products" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-box mr-3"></i>
                            Productos
                        </a>
                    </li>
                    <li>
                        <a href="/posts" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-newspaper mr-3"></i>
                            Posts
                        </a>
                    </li>
                    <li>
                        <a href="/categories" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-tags mr-3"></i>
                            Categorías
                        </a>
                    </li>
                    <li>
                        <a href="/images" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-images mr-3"></i>
                            Imágenes
                        </a>
                    </li>
                    <li class="pt-6">
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold px-3 mb-2">
            Configuración
                        </div>
                        <a href="/settings" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-cog mr-3"></i>
                            Configuración
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Usuario actual -->
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff" 
                         alt="Avatar" 
                         class="w-10 h-10 rounded-full">
                    <div class="ml-3">
                        <p class="font-medium">Admin User</p>
                        <p class="text-sm text-gray-400">Administrador</p>
                    </div>
                    <a href="/logout" class="ml-auto text-gray-400 hover:text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Contenido principal -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
                        <p class="text-gray-600">Administra los usuarios del sistema</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="newUserBtn" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Nuevo Usuario
                        </button>
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Buscar usuario..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Estadísticas -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Usuarios</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">156</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>12% este mes
                        </span>
                    </div>
                </div>
                
                <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Usuarios Activos</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">134</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-check text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>8% este mes
                        </span>
                    </div>
                </div>
                
                <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Usuarios Nuevos</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">23</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>15% este mes
                        </span>
                    </div>
                </div>
                
                <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Administradores</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">8</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-shield text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-600 text-sm font-medium">
                            <i class="fas fa-minus mr-1"></i>Sin cambios
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Tabla de usuarios -->
            <div class="p-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Lista de Usuarios</h3>
                        <p class="text-gray-600 text-sm mt-1">Administra los usuarios registrados en el sistema</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Usuario
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rol
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Registrado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Usuario 1 -->
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="user-avatar" src="https://ui-avatars.com/api/?name=Juan+Perez&background=3b82f6&color=fff" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Juan Pérez</div>
                                                <div class="text-sm text-gray-500">ID: USR-001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">juan.perez@example.com</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Administrador
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="flex items-center">
                                            <span class="status-active"></span>
                                            <span class="text-sm text-gray-900">Activo</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        15/03/2024
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-user-btn" data-id="1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 mr-3 view-user-btn" data-id="1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 delete-user-btn" data-id="1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Usuario 2 -->
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="user-avatar" src="https://ui-avatars.com/api/?name=Maria+Garcia&background=8b5cf6&color=fff" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">María García</div>
                                                <div class="text-sm text-gray-500">ID: USR-002</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">maria.garcia@example.com</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Editor
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="flex items-center">
                                            <span class="status-active"></span>
                                            <span class="text-sm text-gray-900">Activo</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        22/03/2024
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-user-btn" data-id="2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 mr-3 view-user-btn" data-id="2">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 delete-user-btn" data-id="2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Usuario 3 -->
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="user-avatar" src="https://ui-avatars.com/api/?name=Carlos+Lopez&background=10b981&color=fff" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Carlos López</div>
                                                <div class="text-sm text-gray-500">ID: USR-003</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">carlos.lopez@example.com</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Usuario
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="flex items-center">
                                            <span class="status-pending"></span>
                                            <span class="text-sm text-gray-900">Pendiente</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        01/04/2024
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-user-btn" data-id="3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 mr-3 view-user-btn" data-id="3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 delete-user-btn" data-id="3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Usuario 4 -->
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="user-avatar" src="https://ui-avatars.com/api/?name=Ana+Martinez&background=ef4444&color=fff" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Ana Martínez</div>
                                                <div class="text-sm text-gray-500">ID: USR-004</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">ana.martinez@example.com</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Usuario
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="flex items-center">
                                            <span class="status-inactive"></span>
                                            <span class="text-sm text-gray-900">Inactivo</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        10/02/2024
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-user-btn" data-id="4">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 mr-3 view-user-btn" data-id="4">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 delete-user-btn" data-id="4">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">1</span> a <span class="font-medium">4</span> de <span class="font-medium">156</span> resultados
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Anterior</button>
                            <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">1</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">2</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">3</button>
                            <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Exportar datos -->
            <div class="p-6 pt-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Exportar Datos</h3>
                    <div class="flex flex-wrap gap-3">
                        <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium flex items-center transition duration-200">
                            <i class="fas fa-file-excel mr-2"></i>
                            Exportar a Excel
                        </button>
                        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium flex items-center transition duration-200">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Exportar a PDF
                        </button>
                        <button class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg font-medium flex items-center transition duration-200">
                            <i class="fas fa-file-csv mr-2"></i>
                            Exportar a CSV
                        </button>
                        <button class="px-4 py-2 border border-gray-300 hover:bg-gray-50 rounded-lg font-medium flex items-center transition duration-200">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir Lista
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modal para nuevo/editar usuario -->
    <div id="userModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="modal-overlay absolute inset-0"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl">
                <div class="p-6 border-b border-gray-200">
                    <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Nuevo Usuario</h3>
                    <button id="closeModal" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="userForm" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ingrese el nombre">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ingrese el apellido">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="usuario@ejemplo.com">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                            <input type="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Mínimo 8 caracteres">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Repita la contraseña">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="admin">Administrador</option>
                                <option value="editor">Editor</option>
                                <option value="user" selected>Usuario</option>
                                <option value="viewer">Solo lectura</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="active" selected>Activo</option>
                                <option value="inactive">Inactivo</option>
                                <option value="pending">Pendiente</option>
                                <option value="blocked">Bloqueado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                        <textarea rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Notas adicionales sobre el usuario"></textarea>
                    </div>
                </form>
                
                <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                    <button id="cancelModal" class="px-5 py-2 border border-gray-300 rounded-lg font-medium hover:bg-gray-50 transition duration-200">
                        Cancelar
                    </button>
                    <button id="saveUser" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                        Guardar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializar DataTable
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "paging": false,
                "searching": false,
                "info": false,
                "language": {
                    "emptyTable": "No hay datos disponibles",
                    "zeroRecords": "No se encontraron resultados"
                }
            });
        });
        
        // Manejo del modal
        const modal = document.getElementById('userModal');
        const newUserBtn = document.getElementById('newUserBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelModal = document.getElementById('cancelModal');
        const modalTitle = document.getElementById('modalTitle');
        
        newUserBtn.addEventListener('click', () => {
            modalTitle.textContent = 'Nuevo Usuario';
            modal.classList.remove('hidden');
        });
        
        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
        
        cancelModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
        
        // Cerrar modal al hacer clic fuera
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
        
        // Botones de editar usuario
        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', () => {
                modalTitle.textContent = 'Editar Usuario';
                modal.classList.remove('hidden');
                // Aquí cargarías los datos del usuario
            });
        });
        
        // Botones de ver usuario
        document.querySelectorAll('.view-user-btn').forEach(button => {
            button.addEventListener('click', () => {
                alert('Funcionalidad de ver usuario - ID: ' + button.getAttribute('data-id'));
            });
        });
        
        // Botones de eliminar usuario
        document.querySelectorAll('.delete-user-btn').forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                    alert('Usuario eliminado - ID: ' + button.getAttribute('data-id'));
                }
            });
        });
        
        // Guardar usuario
        document.getElementById('saveUser').addEventListener('click', () => {
            alert('Usuario guardado correctamente');
            modal.classList.add('hidden');
        });
        
        // Alternar tema claro/oscuro (opcional)
        const toggleTheme = () => {
            document.body.classList.toggle('bg-gray-900');
            document.body.classList.toggle('text-white');
        };
    </script>
</body>
</html>