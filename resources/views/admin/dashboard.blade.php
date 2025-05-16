<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Administración') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center shadow-sm">
                    <i class="fas fa-home mr-2"></i> Ir al Dashboard
                </a>
                <a href="{{ route('admin.export.users.excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center shadow-sm">
                    <i class="fas fa-file-excel mr-2"></i> Exportar a Excel
                </a>
                <a href="{{ route('admin.export.users.pdf') }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center shadow-sm">
                    <i class="fas fa-file-pdf mr-2"></i> Exportar a PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-blue-500 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="text-lg font-semibold">Usuarios Totales</h5>
                                <h2 class="text-3xl font-bold">{{ $totalUsers }}</h2>
                            </div>
                            <div>
                                <i class="fas fa-users text-4xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-green-500 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="text-lg font-semibold">Archivos Totales</h5>
                                <h2 class="text-3xl font-bold">{{ $totalFiles }}</h2>
                                <span class="text-xs font-light">(Incluye los archivos del admin)</span>
                            </div>
                            <div>
                                <i class="fas fa-file text-4xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-yellow-500 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="text-lg font-semibold">Archivos de Usuarios</h5>
                                <h2 class="text-3xl font-bold">{{ $regularUserFiles }}</h2>
                                <span class="text-xs font-light">(Sin contar los del admin)</span>
                            </div>
                            <div>
                                <i class="fas fa-database text-4xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Lista de usuarios -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        <i class="fas fa-users mr-2"></i>Usuarios Registrados
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Registro</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivos</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->files()->count() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                            <a href="{{ route('admin.user.view', $user->id) }}" class="bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 rounded-lg p-2" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.export.user.excel', $user->id) }}" class="bg-green-100 text-green-600 hover:bg-green-200 hover:text-green-800 rounded-lg p-2" title="Exportar a Excel">
                                                <i class="fas fa-file-excel"></i>
                                            </a>
                                            <a href="{{ route('admin.export.user.pdf', $user->id) }}" class="bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 rounded-lg p-2" title="Exportar a PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="{{ route('admin.export.user.word', $user->id) }}" class="bg-indigo-100 text-indigo-600 hover:bg-indigo-200 hover:text-indigo-800 rounded-lg p-2" title="Exportar a Word">
                                                <i class="fas fa-file-word"></i>
                                            </a>
                                            <a href="{{ route('admin.export.user.zip', $user->id) }}" class="bg-yellow-100 text-yellow-600 hover:bg-yellow-200 hover:text-yellow-800 rounded-lg p-2" title="Descargar ZIP">
                                                <i class="fas fa-file-archive"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 