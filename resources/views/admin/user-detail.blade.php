<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Usuario: ') . $user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Tarjetas de estadísticas del usuario -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-500 rounded-lg p-4 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-sm font-semibold uppercase">Total Archivos</h3>
                                <p class="text-2xl font-bold">{{ $totalFiles }}</p>
                            </div>
                            <i class="fas fa-file-alt text-3xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="bg-green-500 rounded-lg p-4 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-sm font-semibold uppercase">Imágenes</h3>
                                <p class="text-2xl font-bold">{{ $totalImages }}</p>
                            </div>
                            <i class="fas fa-image text-3xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="bg-purple-500 rounded-lg p-4 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-sm font-semibold uppercase">Documentos</h3>
                                <p class="text-2xl font-bold">{{ $totalFiles - $totalImages }}</p>
                            </div>
                            <i class="fas fa-file-pdf text-3xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="bg-yellow-500 rounded-lg p-4 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-sm font-semibold uppercase">Descargas</h3>
                                <p class="text-2xl font-bold">{{ $totalDownloads }}</p>
                            </div>
                            <i class="fas fa-download text-3xl opacity-80"></i>
                        </div>
                    </div>
                </div>

                <!-- Información del usuario -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Información del Usuario</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">ID</p>
                                <p class="font-medium">{{ $user->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nombre</p>
                                <p class="font-medium">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fecha de Registro</p>
                                <p class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de exportación -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Exportar Información</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.export.user.excel', $user->id) }}" class="px-5 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center shadow-sm transition duration-150">
                            <i class="fas fa-file-excel text-xl mr-3"></i> 
                            <span>
                                <span class="font-semibold block">Excel</span>
                                <span class="text-xs opacity-90">Exportar datos</span>
                            </span>
                        </a>
                        <a href="{{ route('admin.export.user.pdf', $user->id) }}" class="px-5 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center shadow-sm transition duration-150">
                            <i class="fas fa-file-pdf text-xl mr-3"></i>
                            <span>
                                <span class="font-semibold block">PDF</span>
                                <span class="text-xs opacity-90">Reporte completo</span>
                            </span>
                        </a>
                        <a href="{{ route('admin.export.user.word', $user->id) }}" class="px-5 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center shadow-sm transition duration-150">
                            <i class="fas fa-file-word text-xl mr-3"></i>
                            <span>
                                <span class="font-semibold block">Word</span>
                                <span class="text-xs opacity-90">Informe detallado</span>
                            </span>
                        </a>
                        <a href="{{ route('admin.export.user.zip', $user->id) }}" class="px-5 py-3 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 flex items-center shadow-sm transition duration-150">
                            <i class="fas fa-file-archive text-xl mr-3"></i>
                            <span>
                                <span class="font-semibold block">ZIP</span>
                                <span class="text-xs opacity-90">Todos los archivos</span>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Lista de archivos del usuario -->
                <div>
                    <h3 class="text-lg font-semibold mb-3">Archivos del Usuario</h3>
                    @if(count($files) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamaño</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descargas</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Favorito</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($files as $file)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $file->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($file->is_image)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Imagen</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Documento</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->downloads }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($file->is_favorite)
                                                    <span class="text-yellow-500"><i class="fas fa-star"></i></span>
                                                @else
                                                    <span class="text-gray-300"><i class="far fa-star"></i></span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('files.download', $file->id) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Descargar">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <p class="text-gray-500">Este usuario no tiene archivos.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 