<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informe de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1 {
            color: #2d3748;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }
        h2 {
            color: #4a5568;
            margin-top: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
        }
        .info-table th {
            background-color: #f7fafc;
            font-weight: bold;
        }
        .files-table {
            width: 100%;
            border-collapse: collapse;
        }
        .files-table th, .files-table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .files-table th {
            background-color: #f7fafc;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Informe de Usuario</h1>
        
        <h2>Datos Personales</h2>
        <table class="info-table">
            <tr>
                <th>ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Fecha de Registro</th>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
        
        <h2>Resumen de Archivos</h2>
        <table class="info-table">
            <tr>
                <th>Total Archivos</th>
                <td>{{ $totalFiles }}</td>
            </tr>
            <tr>
                <th>Imágenes</th>
                <td>{{ $totalImages }}</td>
            </tr>
            <tr>
                <th>Documentos</th>
                <td>{{ $totalDocuments }}</td>
            </tr>
            <tr>
                <th>Favoritos</th>
                <td>{{ $totalFavorites }}</td>
            </tr>
        </table>
        
        @if($user->files->count() > 0)
            <h2>Listado de Archivos</h2>
            <table class="files-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Tamaño</th>
                        <th>Categoría</th>
                        <th>Favorito</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->files as $file)
                        <tr>
                            <td>{{ $file->id }}</td>
                            <td>{{ $file->title }}</td>
                            <td>{{ $file->is_image ? 'Imagen' : 'Documento' }}</td>
                            <td>{{ number_format($file->file_size / 1024, 2) }} KB</td>
                            <td>{{ $file->category }}</td>
                            <td>{{ $file->is_favorite ? 'Sí' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        <div class="footer">
            Documento generado el {{ $date }}
        </div>
    </div>
</body>
</html> 