<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Archivos Físicos Disponibles') }}
            </h2>
            <div>
                <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Sección de Imágenes -->
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-images mr-2 text-blue-500"></i>
                    <span>Imágenes Disponibles ({{ count($images) }})</span>
                </h3>
                
                @if(count($images) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                        @foreach($images as $image)
                            <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                <div class="h-40 w-full overflow-hidden">
                                    <img src="{{ $image['path'] }}" alt="{{ $image['filename'] }}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-3 text-center">
                                    <p class="text-sm font-medium truncate">{{ $image['filename'] }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($image['size'] / 1024, 2) }} KB</p>
                                    <a href="{{ $image['path'] }}" target="_blank" class="mt-2 inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                        Ver Completo
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-100 p-4 rounded-lg text-center mb-8">
                        <p class="text-gray-500">No hay imágenes físicas disponibles.</p>
                    </div>
                @endif
                
                <!-- Sección de Documentos -->
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-file-alt mr-2 text-green-500"></i>
                    <span>Documentos Disponibles ({{ count($documents) }})</span>
                </h3>
                
                @if(count($documents) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($documents as $document)
                            <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                <div class="p-4 text-center">
                                    <i class="fas fa-file-alt text-gray-500 text-4xl mb-3"></i>
                                    <p class="text-sm font-medium truncate">{{ $document['filename'] }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($document['size'] / 1024, 2) }} KB</p>
                                    <a href="{{ $document['path'] }}" target="_blank" class="mt-2 inline-block px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <p class="text-gray-500">No hay documentos físicos disponibles.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout> 