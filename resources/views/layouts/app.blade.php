<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>U4 Introot - Gestor de Archivos</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- SortableJS para funcionalidad de arrastrar -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
        
        <!-- Flowbite -->
        <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            &copy; {{ date('Y') }} U4 Introot - Gestor de Archivos
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
            
            <!-- Botón flotante para acceso rápido al panel admin (solo visible para administradores) -->
            @can('admin')
            <div class="fixed bottom-6 right-6 z-50 animate-bounce-slow">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center w-16 h-16 rounded-full bg-red-600 text-white shadow-xl hover:bg-red-700 hover:scale-110 transition-all duration-300 group" title="Panel de Administración">
                    <i class="fas fa-user-shield text-2xl"></i>
                    <span class="absolute right-20 bg-black bg-opacity-75 text-white text-sm py-2 px-3 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Panel de Admin</span>
                </a>
            </div>
            @endcan
        </div>
        
        @stack('scripts')
        
        <!-- Scripts para Modal Admin -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const adminModalBtn = document.getElementById('adminModalBtn');
                const adminModal = document.getElementById('adminModal');
                const closeAdminModal = document.getElementById('closeAdminModal');
                
                if (adminModalBtn && adminModal && closeAdminModal) {
                    adminModalBtn.addEventListener('click', function() {
                        adminModal.classList.remove('hidden');
                    });
                    
                    closeAdminModal.addEventListener('click', function() {
                        adminModal.classList.add('hidden');
                    });
                    
                    // Cerrar modal al hacer clic fuera del contenido
                    adminModal.addEventListener('click', function(e) {
                        if (e.target === adminModal || e.target.classList.contains('fixed')) {
                            adminModal.classList.add('hidden');
                        }
                    });
                    
                    // Cerrar modal con tecla Escape
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && !adminModal.classList.contains('hidden')) {
                            adminModal.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
