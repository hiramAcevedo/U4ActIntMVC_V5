<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Archivos') }}
            </h2>
            <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="openUploadModal()">
                <i class="fas fa-upload mr-2"></i> Subir Archivo
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Pestañas de categorías -->
                <div class="mb-6 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 {{ !$activeFilter ? 'border-blue-500' : 'border-transparent hover:border-gray-300' }} rounded-t-lg" 
                                    id="all-tab" type="button" role="tab" aria-controls="all" 
                                    aria-selected="{{ !$activeFilter ? 'true' : 'false' }}"
                                    onclick="changeTab('all')">Todos</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 {{ $activeFilter == 'documents' ? 'border-blue-500' : 'border-transparent hover:border-gray-300' }} rounded-t-lg" 
                                    id="documents-tab" type="button" role="tab" aria-controls="documents" 
                                    aria-selected="{{ $activeFilter == 'documents' ? 'true' : 'false' }}"
                                    onclick="changeTab('documents')">Documentos</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 {{ $activeFilter == 'favorites' ? 'border-blue-500' : 'border-transparent hover:border-gray-300' }} rounded-t-lg" 
                                    id="favorites-tab" type="button" role="tab" aria-controls="favorites" 
                                    aria-selected="{{ $activeFilter == 'favorites' ? 'true' : 'false' }}"
                                    onclick="changeTab('favorites')">Favoritos</button>
                        </li>
                    </ul>
                </div>

                <!-- Panel de todos los archivos -->
                <div id="all" class="tabcontent {{ !$activeFilter ? 'block' : 'hidden' }}">
                    @if(count($files) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($files as $file)
                                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                    <div class="p-4 text-center">
                                        @if($file->is_image)
                                            <i class="fas fa-image text-blue-500 text-4xl mb-3"></i>
                                        @else
                                            <i class="fas fa-file-alt text-gray-500 text-4xl mb-3"></i>
                                        @endif
                                        <h5 class="text-lg font-semibold mb-1">{{ $file->title }}</h5>
                                        <p class="text-sm text-gray-500 mb-2">
                                            {{ number_format($file->file_size / 1024, 2) }} KB | 
                                            {{ $file->file_ext }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-2 border-t flex justify-center space-x-2">
                                        <a href="{{ route('files.download', $file->id) }}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('files.favorite', $file->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fas {{ $file->is_favorite ? 'fa-star' : 'fa-star-o' }}"></i>
                                        </a>
                                        <a href="{{ route('files.delete', $file->id) }}" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este archivo?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">No tienes archivos subidos. ¡Comienza subiendo tu primer archivo!</p>
                        </div>
                    @endif
                </div>
                
                <!-- Panel de documentos -->
                <div id="documents" class="tabcontent {{ $activeFilter == 'documents' ? 'block' : 'hidden' }}">
                    @if(count($documents) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($documents as $document)
                                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                    <div class="p-4 text-center">
                                        <i class="fas fa-file-alt text-gray-500 text-4xl mb-3"></i>
                                        <h5 class="text-lg font-semibold mb-1">{{ $document->title }}</h5>
                                        <p class="text-sm text-gray-500 mb-2">
                                            {{ number_format($document->file_size / 1024, 2) }} KB | 
                                            {{ $document->file_ext }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-2 border-t flex justify-center space-x-2">
                                        <a href="{{ route('files.download', $document->id) }}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('files.favorite', $document->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fas {{ $document->is_favorite ? 'fa-star' : 'fa-star-o' }}"></i>
                                        </a>
                                        <a href="{{ route('files.delete', $document->id) }}" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este archivo?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">No tienes documentos subidos.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Panel de favoritos -->
                <div id="favorites" class="tabcontent {{ $activeFilter == 'favorites' ? 'block' : 'hidden' }}">
                    @if(count($favorites) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($favorites as $favorite)
                                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                    <div class="p-4 text-center">
                                        @if($favorite->is_image)
                                            <i class="fas fa-image text-blue-500 text-4xl mb-3"></i>
                                        @else
                                            <i class="fas fa-file-alt text-gray-500 text-4xl mb-3"></i>
                                        @endif
                                        <h5 class="text-lg font-semibold mb-1">{{ $favorite->title }}</h5>
                                        <p class="text-sm text-gray-500 mb-2">
                                            {{ number_format($favorite->file_size / 1024, 2) }} KB | 
                                            {{ $favorite->file_ext }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-2 border-t flex justify-center space-x-2">
                                        <a href="{{ route('files.download', $favorite->id) }}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('files.favorite', $favorite->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a href="{{ route('files.delete', $favorite->id) }}" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este archivo?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-star text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">No tienes archivos marcados como favoritos.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de subida de archivos -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center {{ $showUploadModal ? '' : 'hidden' }}">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-4 border-b border-gray-200">
                <h5 class="text-lg font-semibold">Subir Nuevo Archivo</h5>
            </div>
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4 space-y-4">
                    <div>
                        <label for="fileTitle" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                        <input type="text" id="fileTitle" name="fileTitle" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="fileDescription" class="block text-sm font-medium text-gray-700 mb-1">Descripción (opcional)</label>
                        <textarea id="fileDescription" name="fileDescription" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    </div>
                    <div>
                        <label for="fileCategory" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select id="fileCategory" name="fileCategory" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="document">Documento</option>
                            <option value="spreadsheet">Hoja de cálculo</option>
                            <option value="presentation">Presentación</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label for="fileUpload" class="block text-sm font-medium text-gray-700 mb-1">Archivo</label>
                        <input type="file" id="fileUpload" name="fileUpload" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                        <p class="text-xs text-gray-500 mt-1">Tamaño máximo: 20MB</p>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2" onclick="closeUploadModal()">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Subir</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
        }
        
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }
        
        function changeTab(tabName) {
            // Ocultar todas las pestañas
            var tabcontent = document.getElementsByClassName("tabcontent");
            for (var i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.add('hidden');
                tabcontent[i].classList.remove('block');
            }
            
            // Mostrar la pestaña seleccionada
            document.getElementById(tabName).classList.remove('hidden');
            document.getElementById(tabName).classList.add('block');
            
            // Actualizar estilos de los botones
            var tabs = document.querySelectorAll('[role="tab"]');
            tabs.forEach(tab => {
                tab.classList.remove('border-blue-500');
                tab.classList.add('border-transparent', 'hover:border-gray-300');
                tab.setAttribute('aria-selected', 'false');
            });
            
            document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'hover:border-gray-300');
            document.getElementById(tabName + '-tab').classList.add('border-blue-500');
            document.getElementById(tabName + '-tab').setAttribute('aria-selected', 'true');
        }
    </script>
</x-app-layout> 