<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Imágenes') }}
            </h2>
            <button type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 shadow-md transition-all duration-200" onclick="openUploadModal()">
                <i class="fas fa-upload mr-2"></i> Subir Imagen
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

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Pestañas de categorías -->
                <div class="mb-6 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-primary-600 text-primary-700 rounded-t-lg active" id="all-tab" type="button" role="tab" aria-controls="all" aria-selected="true">Todas las Imágenes</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg" id="favorites-tab" type="button" role="tab" aria-controls="favorites" aria-selected="false">Favoritos</button>
                        </li>
                    </ul>
                </div>

                <!-- Galería de imágenes con SortableJS -->
                <div id="all" role="tabpanel" aria-labelledby="all-tab">
                    @if(count($images) > 0)
                        <p class="mb-4 text-sm text-gray-600">Puedes arrastrar y soltar las imágenes para ordenarlas a tu gusto:</p>
                        <div id="sortable-images" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                            @foreach($images as $image)
                                <div class="bg-white border rounded-lg shadow-sm overflow-hidden sortable-item cursor-grab active:cursor-grabbing hover:shadow-md transition-all duration-200" data-id="{{ $image->id }}">
                                    <div class="relative group">
                                        <div class="h-40 w-full overflow-hidden">
                                            <img src="{{ asset($image->file_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover hover:scale-110 transition-all duration-300">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                <div class="hidden group-hover:flex gap-2">
                                                    <button type="button" class="p-2 bg-white rounded-full hover:bg-gray-100 shadow-sm hover:shadow transition-all duration-200" onclick="previewImage('{{ asset($image->file_path) }}', '{{ $image->title }}')">
                                                        <i class="fas fa-search text-primary-700"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 text-center bg-white">
                                            <h5 class="text-sm font-medium truncate" title="{{ $image->title }}">{{ $image->title }}</h5>
                                            <p class="text-xs text-gray-500">
                                                {{ number_format($image->file_size / 1024, 2) }} KB
                                            </p>
                                            @if($image->description)
                                            <p class="text-xs text-gray-600 mt-1 line-clamp-2" title="{{ $image->description }}">
                                                {{ \Illuminate\Support\Str::limit($image->description, 60) }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-1.5 border-t flex justify-center space-x-2">
                                        <a href="{{ route('files.download', $image->id) }}" class="text-black bg-primary-100 hover:bg-primary-200 p-1.5 rounded-full transition-all duration-200" title="Descargar">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>
                                        <a href="{{ route('files.favorite', $image->id) }}" class="text-black bg-amber-100 hover:bg-amber-200 p-1.5 rounded-full transition-all duration-200" title="{{ $image->is_favorite ? 'Quitar de favoritos' : 'Añadir a favoritos' }}">
                                            <i class="fas {{ $image->is_favorite ? 'fa-star' : 'fa-star-o' }} text-xs"></i>
                                        </a>
                                        <a href="{{ route('files.delete', $image->id) }}" class="text-black bg-red-100 hover:bg-red-200 p-1.5 rounded-full transition-all duration-200" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta imagen?');">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-image text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">No tienes imágenes subidas. ¡Comienza subiendo tu primera imagen!</p>
                        </div>
                    @endif
                </div>
                
                <!-- Panel de favoritos -->
                <div id="favorites" role="tabpanel" aria-labelledby="favorites-tab" class="hidden">
                    @if(count($favorites) > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                            @foreach($favorites as $favorite)
                                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                                    <div class="relative group">
                                        <div class="h-40 w-full overflow-hidden">
                                            <img src="{{ asset($favorite->file_path) }}" alt="{{ $favorite->title }}" class="w-full h-full object-cover hover:scale-110 transition-all duration-300">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                <div class="hidden group-hover:flex gap-2">
                                                    <button type="button" class="p-2 bg-white rounded-full hover:bg-gray-100 shadow-sm hover:shadow transition-all duration-200" onclick="previewImage('{{ asset($favorite->file_path) }}', '{{ $favorite->title }}')">
                                                        <i class="fas fa-search text-primary-700"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 text-center bg-white">
                                            <h5 class="text-sm font-medium truncate" title="{{ $favorite->title }}">{{ $favorite->title }}</h5>
                                            <p class="text-xs text-gray-500">
                                                {{ number_format($favorite->file_size / 1024, 2) }} KB
                                            </p>
                                            @if($favorite->description)
                                            <p class="text-xs text-gray-600 mt-1 line-clamp-2" title="{{ $favorite->description }}">
                                                {{ \Illuminate\Support\Str::limit($favorite->description, 60) }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-1.5 border-t flex justify-center space-x-2">
                                        <a href="{{ route('files.download', $favorite->id) }}" class="text-black bg-primary-100 hover:bg-primary-200 p-1.5 rounded-full transition-all duration-200" title="Descargar">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>
                                        <a href="{{ route('files.favorite', $favorite->id) }}" class="text-black bg-amber-100 hover:bg-amber-200 p-1.5 rounded-full transition-all duration-200" title="Quitar de favoritos">
                                            <i class="fas fa-star text-xs"></i>
                                        </a>
                                        <a href="{{ route('files.delete', $favorite->id) }}" class="text-black bg-red-100 hover:bg-red-200 p-1.5 rounded-full transition-all duration-200" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta imagen?');">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-star text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">No tienes imágenes favoritas. Marca una imagen como favorita para verla aquí.</p>
                        </div>
                    @endif
                </div>

                <!-- Botón de subida de imagen (ya no flotante) -->
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('files.images') }}?action=upload" class="flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-300 button-hover-slide card-shadow">
                        <i class="fas fa-plus text-xl mr-2"></i>
                        <span>Subir Nueva Imagen</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de subida de imágenes -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center {{ $showUploadModal ? '' : 'hidden' }}" tabindex="-1">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 bg-white p-4 border-b border-gray-200 flex justify-between items-center z-10">
                <h5 class="text-lg font-semibold">Subir Nueva Imagen</h5>
                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeUploadModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="overflow-y-auto p-0 max-h-[calc(90vh-130px)]">
                <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="p-4 space-y-4">
                        <div>
                            <label for="fileTitle" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                            <input type="text" id="fileTitle" name="fileTitle" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="fileDescription" class="block text-sm font-medium text-gray-700 mb-1">Descripción (opcional)</label>
                            <textarea id="fileDescription" name="fileDescription" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50"></textarea>
                        </div>
                        <div>
                            <label for="fileCategory" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select id="fileCategory" name="fileCategory" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                <option value="photo">Fotografía</option>
                                <option value="artwork">Arte</option>
                                <option value="screenshot">Captura de pantalla</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                        <div>
                            <label for="fileUpload" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                            <input type="file" id="fileUpload" name="fileUpload" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                            <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB</p>
                        </div>
                        <div class="border p-3 rounded-lg bg-gray-50">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Vista previa:</span>
                            </div>
                            <div id="imagePreviewContainer" class="flex justify-center items-center bg-gray-200 rounded-lg mb-2 hidden" style="height: 250px; max-height: 250px; overflow: hidden;">
                                <img id="imagePreview" class="max-h-full max-w-full object-contain" style="max-height: 240px; max-width: 100%;" src="#" alt="Vista previa">
                            </div>
                            <div id="placeholderContainer" class="flex justify-center items-center h-48 bg-gray-200 rounded-lg mb-2">
                                <i class="fas fa-image text-gray-400 text-5xl"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="sticky bottom-0 bg-white p-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 transition-all duration-200" onclick="closeUploadModal()">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>
                <button type="submit" form="uploadForm" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 shadow-md transition-all duration-200">
                    <i class="fas fa-upload mr-1"></i> Subir Imagen
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de vista previa de imagen -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 flex items-center justify-center hidden" tabindex="-1">
        <div class="relative max-w-4xl w-full mx-4">
            <button type="button" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300" onclick="closeImagePreview()">
                <i class="fas fa-times"></i>
            </button>
            <div class="p-2 bg-white rounded-lg overflow-hidden">
                <img id="fullImagePreview" class="w-full h-auto max-h-[80vh] object-contain" src="" alt="">
            </div>
            <div class="mt-2 text-white text-center">
                <h3 id="imagePreviewTitle" class="text-xl font-medium"></h3>
            </div>
        </div>
    </div>

    <!-- Asegurar la carga de SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
        
        .animate-fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }
        
        /* Mejorar estilo de mosaico */
        #sortable-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
        
        .sortable-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        
        .sortable-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Truncar textos largos */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    
    <!-- Script de inicialización directa para SortableJS -->
    <script>
        // Script de inicialización directa para garantizar que funcione
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicialización directa de Sortable');
            const container = document.getElementById('sortable-images');
            if (container) {
                try {
                    // Inicialización mínima de Sortable
                    const sortInstance = new Sortable(container, {
                        animation: 150,
                        ghostClass: 'bg-primary-100'
                    });
                    console.log('Sortable inicializado directamente con éxito');
                } catch (e) {
                    console.error('Error en inicialización directa:', e);
                }
            } else {
                console.warn('No se encontró el contenedor para Sortable');
            }
        });
    </script>
    
    @push('scripts')
    <script>
        // Verificar que Sortable se haya cargado correctamente
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM cargado completamente');
            
            if (typeof Sortable === 'undefined') {
                console.error('ERROR: La librería SortableJS no se ha cargado correctamente');
                // Intentar cargar de nuevo si falló la primera vez
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
                script.onload = function() {
                    console.log('SortableJS cargado correctamente después de reintento');
                    initializePage();
                };
                script.onerror = function() {
                    console.error('Falló la carga de SortableJS incluso después de reintento');
                };
                document.head.appendChild(script);
            } else {
                console.log('SortableJS cargado correctamente');
                initializePage();
            }
            
            // Manejar el modal si debe mostrarse automáticamente
            const uploadModal = document.getElementById('uploadModal');
            if (uploadModal && !uploadModal.classList.contains('hidden')) {
                openUploadModal();
            }
            
            // Manejo de errores en imágenes
            const imagenes = document.querySelectorAll('img');
            imagenes.forEach(img => {
                // Detectar errores de carga
                img.addEventListener('error', function() {
                    console.error('Error al cargar imagen:', this.src);
                    this.style.border = '2px solid red';
                    this.style.padding = '5px';
                    this.src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22100%22%20height%3D%22100%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M12%2016.99V17M12%207V14M12%2021C16.9706%2021%2021%2016.9706%2021%2012C21%207.02944%2016.9706%203%2012%203C7.02944%203%203%207.02944%203%2012C3%2016.9706%207.02944%2021%2012%2021Z%22%20stroke%3D%22%23ff0000%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E';
                });
                
                // Confirmar carga correcta
                img.addEventListener('load', function() {
                    console.log('Imagen cargada correctamente:', this.src);
                });
            });
        });
        
        // Función principal de inicialización
        function initializePage() {
            console.log('Inicializando página...');
            initSortable();
            initTabs();
            initImagePreview();
        }
        
        function previewImage(imageSrc, imageTitle) {
            const modal = document.getElementById('imagePreviewModal');
            const image = document.getElementById('fullImagePreview');
            const title = document.getElementById('imagePreviewTitle');
            
            image.src = imageSrc;
            title.textContent = imageTitle;
            modal.classList.remove('hidden');
            
            // Permitir cerrar con ESC
            const escHandler = function(e) {
                if (e.key === 'Escape') {
                    closeImagePreview();
                    document.removeEventListener('keydown', escHandler);
                }
            };
            
            document.addEventListener('keydown', escHandler);
            
            // Permitir cerrar haciendo clic fuera de la imagen
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeImagePreview();
                }
            }, { once: true });
        }
        
        function closeImagePreview() {
            document.getElementById('imagePreviewModal').classList.add('hidden');
        }
        
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
            // Enfoca el modal para que funcione el evento keydown
            document.getElementById('uploadModal').focus();
            
            // Agregar evento para cerrar con ESC
            document.addEventListener('keydown', function modalEscHandler(e) {
                if (e.key === 'Escape' && !document.getElementById('uploadModal').classList.contains('hidden')) {
                    closeUploadModal();
                    document.removeEventListener('keydown', modalEscHandler);
                }
            });
            
            // Permitir cerrar haciendo clic fuera del contenido
            document.getElementById('uploadModal').addEventListener('click', function modalClickHandler(e) {
                if (e.target === document.getElementById('uploadModal')) {
                    closeUploadModal();
                }
            }, { once: true });
        }
        
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            // Reset de la vista previa
            const fileInput = document.getElementById('fileUpload');
            if (fileInput) {
                fileInput.value = '';
            }
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const placeholderContainer = document.getElementById('placeholderContainer');
            if (imagePreviewContainer && placeholderContainer) {
                imagePreviewContainer.classList.add('hidden');
                placeholderContainer.classList.remove('hidden');
            }
            
            // Resetear el formulario
            const form = document.getElementById('uploadForm');
            if (form) {
                form.reset();
            }
        }
        
        function initSortable() {
            var el = document.getElementById('sortable-images');
            if (!el) {
                console.error('No se encontró el elemento #sortable-images');
                return;
            }
            
            // Limpiar configuración previa si existe
            if (el.sortable) {
                el.sortable.destroy();
            }
            
            // Implementación simplificada para depuración
            try {
                console.log('Inicializando Sortable básico en:', el);
                
                // Configuración mínima para funcionar
                new Sortable(el, {
                    animation: 150,
                    ghostClass: 'bg-primary-100',
                    onEnd: function(evt) {
                        console.log('Arrastre finalizado - de:', evt.oldIndex, 'a:', evt.newIndex);
                        
                        // Obtener todos los elementos ordenables
                        let items = Array.from(el.querySelectorAll('.sortable-item')).map((item, index) => {
                            return {
                                id: item.dataset.id,
                                order: index
                            };
                        });
                        
                        console.log('Guardando nuevo orden:', items);
                        
                        // Obtener el token CSRF
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        // Enviar al servidor
                        fetch('{{ route("api.images.updateOrder") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ items: items })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Respuesta del servidor:', data);
                            if (data.success) {
                                showToast('Orden actualizado correctamente', 'success');
                            } else {
                                showToast('Error al actualizar el orden', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error al actualizar el orden:', error);
                            showToast('Error al actualizar el orden', 'error');
                        });
                    }
                });
                
                console.log('Sortable inicializado correctamente');
            } catch (error) {
                console.error('Error al inicializar Sortable:', error);
            }
        }
        
        // Función para mostrar notificaciones toast
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in-up`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 2000);
        }
        
        function initTabs() {
            const tabs = document.querySelectorAll('[role="tab"]');
            const tabPanels = document.querySelectorAll('[role="tabpanel"]');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Desactivar todas las pestañas
                    tabs.forEach(t => {
                        t.classList.remove('border-primary-600', 'text-primary-700');
                        t.classList.add('border-transparent', 'text-gray-500');
                        t.setAttribute('aria-selected', 'false');
                    });
                    
                    // Activar la pestaña actual
                    tab.classList.remove('border-transparent', 'text-gray-500');
                    tab.classList.add('border-primary-600', 'text-primary-700');
                    tab.setAttribute('aria-selected', 'true');
                    
                    // Ocultar todos los paneles
                    tabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    // Mostrar el panel correspondiente
                    const panelId = tab.getAttribute('aria-controls');
                    document.getElementById(panelId).classList.remove('hidden');
                });
            });
        }
        
        function initImagePreview() {
            const fileInput = document.getElementById('fileUpload');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const placeholderContainer = document.getElementById('placeholderContainer');
            
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        console.log('Archivo seleccionado:', file.name, 'tipo:', file.type, 'tamaño:', file.size);
                        
                        // Verificar que sea una imagen
                        if (!file.type.match('image.*')) {
                            alert('Por favor selecciona una imagen válida (JPG, PNG, GIF)');
                            this.value = '';
                            return;
                        }
                        
                        // Verificar tamaño (5MB máximo)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('La imagen seleccionada es demasiado grande. El tamaño máximo es 5MB');
                            this.value = '';
                            return;
                        }
                        
                        const reader = new FileReader();
                        
                        // Manejar errores de lectura
                        reader.onerror = function() {
                            console.error('Error al leer el archivo:', reader.error);
                            alert('Error al leer el archivo. Por favor, intenta con otra imagen.');
                        };
                        
                        reader.onload = function(e) {
                            console.log('Archivo leído correctamente');
                            
                            // Establecer la imagen y mostrarla inmediatamente
                            imagePreview.src = e.target.result;
                            imagePreviewContainer.classList.remove('hidden');
                            placeholderContainer.classList.add('hidden');
                            
                            // Manejar error de carga de imagen
                            imagePreview.onerror = function() {
                                console.error('Error al cargar la previsualización');
                                imagePreviewContainer.classList.add('hidden');
                                placeholderContainer.classList.remove('hidden');
                                alert('Error al mostrar la previsualización. La imagen podría estar dañada.');
                            };
                            
                            // Crear una imagen temporal para obtener dimensiones reales
                            const tempImage = new Image();
                            
                            tempImage.onerror = function() {
                                console.error('Error al cargar imagen temporal');
                            };
                            
                            tempImage.onload = function() {
                                console.log('Dimensiones detectadas:', tempImage.width, 'x', tempImage.height);
                                
                                // Establecer atributos data para dimensiones originales
                                imagePreview.setAttribute('data-original-width', tempImage.width);
                                imagePreview.setAttribute('data-original-height', tempImage.height);
                                
                                // Ajustar el contenedor según la relación de aspecto
                                const aspectRatio = tempImage.width / tempImage.height;
                                console.log('Relación de aspecto:', aspectRatio);
                                
                                if (aspectRatio > 1.5) {
                                    // Imagen más ancha que alta
                                    imagePreviewContainer.style.height = '250px';
                                } else if (aspectRatio < 0.7) {
                                    // Imagen más alta que ancha
                                    imagePreviewContainer.style.height = '350px';
                                } else {
                                    // Imagen cuadrada o cercana a cuadrada
                                    imagePreviewContainer.style.height = '300px';
                                }
                            };
                            
                            tempImage.src = e.target.result;
                        };
                        
                        reader.readAsDataURL(file);
                    } else {
                        // No hay archivo seleccionado, mostrar placeholder
                        imagePreviewContainer.classList.add('hidden');
                        placeholderContainer.classList.remove('hidden');
                    }
                });
            }
        }
    </script>
    
    @if(isset($showUploadModal) && $showUploadModal)
    <script>
        // Esperar a que se cargue el DOM antes de abrir el modal
        document.addEventListener('DOMContentLoaded', function() {
            // El modal se abrirá desde el evento DOMContentLoaded principal
            console.log('Modal debe abrirse automáticamente');
        });
    </script>
    @endif
    @endpush
</x-app-layout> 