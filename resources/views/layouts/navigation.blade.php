<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @can('admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <span class="font-semibold text-lg text-blue-600">Hiram U4ActInt</span>
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="font-semibold text-lg text-blue-600">Hiram U4ActInt</span>
                    </a>
                    @endcan
                </div>
                
                <!-- Botón de Admin (siempre visible para administradores) -->
                @can('admin')
                <div class="shrink-0 flex items-center ml-4">
                    <button id="adminModalBtn" type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                        <i class="fas fa-user-shield mr-1.5"></i> Panel Admin
                    </button>
                </div>
                
                <!-- Modal de Admin -->
                <div id="adminModal" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden">
                    <div class="relative flex min-h-screen items-center justify-center p-4">
                        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                        <div class="relative max-w-md w-full bg-white rounded-lg shadow-xl">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        <i class="fas fa-user-shield text-red-600 mr-2"></i>Panel de Administración
                                    </h3>
                                    <button id="closeAdminModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5 ml-auto inline-flex items-center">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <p class="text-sm text-gray-600">Accede rápidamente a las funciones de administración:</p>
                                    <div class="grid grid-cols-2 gap-3">
                                        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                                            <i class="fas fa-tachometer-alt text-2xl text-blue-600 mb-2"></i>
                                            <span class="text-sm font-medium">Dashboard</span>
                                        </a>
                                        <a href="{{ route('admin.export.users.excel') }}" class="flex flex-col items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                                            <i class="fas fa-file-excel text-2xl text-green-600 mb-2"></i>
                                            <span class="text-sm font-medium">Exportar Excel</span>
                                        </a>
                                        <a href="{{ route('admin.export.users.pdf') }}" class="flex flex-col items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                                            <i class="fas fa-file-pdf text-2xl text-red-600 mb-2"></i>
                                            <span class="text-sm font-medium">Exportar PDF</span>
                                        </a>
                                        <a href="#" class="flex flex-col items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                                            <i class="fas fa-cog text-2xl text-gray-600 mb-2"></i>
                                            <span class="text-sm font-medium">Configuración</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center">
                        <i class="fas fa-home mr-1"></i>
                        <span>{{ __('Inicio') }}</span>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('files.index')" :active="request()->routeIs('files.index')" class="flex items-center">
                        <i class="fas fa-file-alt mr-1"></i>
                        <span>{{ __('Archivos') }}</span>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('files.images')" :active="request()->routeIs('files.images')" class="flex items-center">
                        <i class="fas fa-images mr-1"></i>
                        <span>{{ __('Imágenes') }}</span>
                    </x-nav-link>
                    
                    @can('admin')
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="flex items-center text-red-500 font-medium">
                        <span>{{ __('Administrador') }}</span>
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Help Button -->
                <div x-data="{ showHelp: false }">
                    <button @click="showHelp = !showHelp" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out mr-4 relative">
                        <i class="fas fa-question-circle text-lg"></i>
                    </button>
                    <div x-show="showHelp" @click.away="showHelp = false" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg p-4 border border-gray-200 z-50" style="display: none">
                        <h3 class="font-medium text-gray-800 mb-2">Ayuda Rápida</h3>
                        @can('admin')
                        <div class="text-sm text-gray-600 space-y-2">
                            <p><i class="fas fa-user-shield text-red-500 mr-1"></i> Estás en modo Administrador.</p>
                            <p>Desde aquí puedes:</p>
                            <ul class="pl-4 list-disc">
                                <li>Gestionar todos los usuarios</li>
                                <li>Ver estadísticas generales</li>
                                <li>Exportar datos a Excel/PDF</li>
                                <li>Acceder a configuraciones avanzadas</li>
                            </ul>
                            <div class="mt-2 text-xs bg-blue-50 p-2 rounded">
                                <p class="font-medium text-blue-600"><i class="fas fa-info-circle mr-1"></i> Nota sobre estadísticas:</p>
                                <p>El conteo de archivos incluye los archivos subidos por ti (admin). Para ver solo los archivos de usuarios regulares, consulta la tarjeta "Archivos de Usuarios" en el panel.</p>
                            </div>
                        </div>
                        @else
                        <div class="text-sm text-gray-600 space-y-2">
                            <p><i class="fas fa-user text-blue-500 mr-1"></i> Bienvenido a tu cuenta.</p>
                            <p>Desde aquí puedes:</p>
                            <ul class="pl-4 list-disc">
                                <li>Gestionar tus archivos</li>
                                <li>Ver tus imágenes</li>
                                <li>Actualizar tu perfil</li>
                                <li>Organizar tu contenido</li>
                            </ul>
                        </div>
                        @endcan
                    </div>
                </div>
                
                <!-- User dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=fff" alt="{{ Auth::user()->name }}" class="h-6 w-6 rounded-full mr-2">
                                <span class="truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <div class="text-xs text-gray-500">Usuario</div>
                            <div class="font-semibold truncate max-w-[200px]">{{ Auth::user()->email }}</div>
                        </div>
                        
                        @can('admin')
                        <x-dropdown-link :href="route('admin.dashboard')" class="flex items-center text-red-500 font-medium">
                            <i class="fas fa-user-shield mr-2"></i>
                            {{ __('Administrador') }}
                        </x-dropdown-link>
                        @endcan
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('files.index')" class="flex items-center">
                            <i class="fas fa-file-archive mr-2"></i>
                            {{ __('Mis Archivos') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="flex items-center text-red-500">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center">
                <i class="fas fa-home mr-2"></i>
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('files.index')" :active="request()->routeIs('files.index')" class="flex items-center">
                <i class="fas fa-file-alt mr-2"></i>
                {{ __('Archivos') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('files.images')" :active="request()->routeIs('files.images')" class="flex items-center">
                <i class="fas fa-images mr-2"></i>
                {{ __('Imágenes') }}
            </x-responsive-nav-link>
            
            @can('admin')
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="flex items-center text-red-500 font-medium">
                <i class="fas fa-user-shield mr-2"></i>
                {{ __('Administrador') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=fff" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full">
                </div>
                <div class="ml-3 overflow-hidden">
                    <div class="font-medium text-base text-gray-800 truncate">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                @can('admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" class="flex items-center text-red-500 font-medium">
                    <i class="fas fa-user-shield mr-2"></i>
                    {{ __('Administrador') }}
                </x-responsive-nav-link>
                @endcan
                
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center">
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="flex items-center text-red-500">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
