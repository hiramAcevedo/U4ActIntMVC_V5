<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-tachometer-alt mr-2 text-blue-500"></i>{{ __('Panel Principal') }}
            </h2>
            <div class="text-sm text-gray-500">Bienvenido de nuevo, {{ Auth::user()->name }}</div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas del usuario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-chart-line mr-2 text-blue-500"></i>
                        <span>Tus Estadísticas</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-all border border-blue-200">
                            <div class="bg-blue-500 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-alt text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-blue-800 mb-1">{{ Auth::user()->files()->count() }}</div>
                            <div class="text-sm text-blue-600 font-medium">Archivos Totales</div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-all border border-green-200">
                            <div class="bg-green-500 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-image text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-green-800 mb-1">{{ Auth::user()->images()->count() }}</div>
                            <div class="text-sm text-green-600 font-medium">Imágenes</div>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-all border border-yellow-200">
                            <div class="bg-yellow-500 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-star text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-yellow-800 mb-1">{{ Auth::user()->favorites()->count() }}</div>
                            <div class="text-sm text-yellow-600 font-medium">Favoritos</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Botón de archivos -->
                <a href="{{ route('files.index') }}" class="block group">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-blue-400 group-hover:border-blue-600 transition-all transform group-hover:scale-105 h-full">
                        <div class="p-8 text-center">
                            <div class="bg-blue-100 text-blue-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 group-hover:text-white transition-all">
                                <i class="fas fa-file-alt text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mis Archivos</h3>
                            <p class="text-gray-600 mb-4">Gestiona todos tus documentos</p>
                            <div class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg group-hover:bg-blue-600 transition">
                                <i class="fas fa-arrow-right mr-1"></i> Acceder Ahora
                            </div>
                        </div>
                    </div>
                </a>
                
                <!-- Botón de imágenes -->
                <a href="{{ route('files.images') }}" class="block group">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-green-400 group-hover:border-green-600 transition-all transform group-hover:scale-105 h-full">
                        <div class="p-8 text-center">
                            <div class="bg-green-100 text-green-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 group-hover:text-white transition-all">
                                <i class="fas fa-images text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mis Imágenes</h3>
                            <p class="text-gray-600 mb-4">Visualiza y organiza tus fotos</p>
                            <div class="inline-block px-4 py-2 bg-green-500 text-white rounded-lg group-hover:bg-green-600 transition">
                                <i class="fas fa-arrow-right mr-1"></i> Ver Galería
                            </div>
                        </div>
                    </div>
                </a>
                
                <!-- Botón de configuración -->
                <a href="{{ route('profile.edit') }}" class="block group">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-purple-400 group-hover:border-purple-600 transition-all transform group-hover:scale-105 h-full">
                        <div class="p-8 text-center">
                            <div class="bg-purple-100 text-purple-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500 group-hover:text-white transition-all">
                                <i class="fas fa-user-cog text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mi Perfil</h3>
                            <p class="text-gray-600 mb-4">Configura tu cuenta</p>
                            <div class="inline-block px-4 py-2 bg-purple-500 text-white rounded-lg group-hover:bg-purple-600 transition">
                                <i class="fas fa-arrow-right mr-1"></i> Editar Perfil
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-bolt mr-2 text-amber-500"></i>
                        <span>Acciones Rápidas</span>
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('files.index') }}?action=upload" class="flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:shadow-md transition-all border border-gray-200 group">
                            <div class="text-blue-500 text-2xl mb-2 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <span class="text-center text-sm font-medium">Subir Archivo</span>
                        </a>
                        
                        <a href="{{ route('files.images') }}?action=upload" class="flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:shadow-md transition-all border border-gray-200 group">
                            <div class="text-green-500 text-2xl mb-2 group-hover:scale-110 transition-transform">
                                <i class="fas fa-camera"></i>
                            </div>
                            <span class="text-center text-sm font-medium">Subir Imagen</span>
                        </a>
                        
                        <a href="{{ route('files.index') }}?filter=favorites" class="flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:shadow-md transition-all border border-gray-200 group">
                            <div class="text-yellow-500 text-2xl mb-2 group-hover:scale-110 transition-transform">
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-center text-sm font-medium">Ver Favoritos</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:shadow-md transition-all border border-gray-200 group">
                            <div class="text-red-500 text-2xl mb-2 group-hover:scale-110 transition-transform">
                                <i class="fas fa-key"></i>
                            </div>
                            <span class="text-center text-sm font-medium">Cambiar Contraseña</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
