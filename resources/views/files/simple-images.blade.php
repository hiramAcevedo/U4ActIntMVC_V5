<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imágenes - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Mis Imágenes</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            @if(count($images) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($images as $image)
                        <div class="border rounded-lg overflow-hidden">
                            <div class="h-40 overflow-hidden">
                                <img src="{{ asset($image->file_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3">
                                <h5 class="font-medium text-sm">{{ $image->title }}</h5>
                                <p class="text-xs text-gray-500">{{ number_format($image->file_size / 1024, 2) }} KB</p>
                            </div>
                            <div class="bg-gray-50 py-2 px-3 flex justify-center space-x-2 border-t">
                                <a href="{{ route('files.download', $image->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Descargar</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No tienes imágenes subidas.</p>
            @endif
            
            <div class="mt-8 flex justify-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html> 