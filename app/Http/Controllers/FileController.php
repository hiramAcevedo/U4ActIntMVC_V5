<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Mostrar el listado de archivos del usuario.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        
        // Obtener archivos agrupados por categoría
        $files = UserFile::where('user_id', $userId)->get();
        $documents = UserFile::where('user_id', $userId)->where('is_image', false)->get();
        $images = UserFile::where('user_id', $userId)->where('is_image', true)->get();
        $favorites = UserFile::where('user_id', $userId)->where('is_favorite', true)->get();
        
        // Determinar si mostrar el modal de carga
        $showUploadModal = $request->has('action') && $request->action === 'upload';
        
        // Filtro específico si se solicita
        $activeFilter = $request->filter ?? null;
        
        return view('files.index', [
            'files' => $files,
            'documents' => $documents,
            'images' => $images,
            'favorites' => $favorites,
            'showUploadModal' => $showUploadModal,
            'activeFilter' => $activeFilter
        ]);
    }

    /**
     * Mostrar solo las imágenes del usuario.
     */
    public function images(Request $request)
    {
        $userId = auth()->id();
        $images = UserFile::where('user_id', $userId)
                        ->where('is_image', true)
                        ->orderBy('display_order')
                        ->get();
        $favorites = UserFile::where('user_id', $userId)
                            ->where('is_image', true)
                            ->where('is_favorite', true)
                            ->orderBy('display_order')
                            ->get();
        
        // Determinar si mostrar el modal de carga
        $showUploadModal = $request->has('action') && $request->action === 'upload';
        
        return view('files.images', [
            'images' => $images,
            'favorites' => $favorites,
            'showUploadModal' => $showUploadModal
        ]);
    }

    /**
     * Subir un nuevo archivo.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'fileTitle' => 'required|string|max:255',
            'fileDescription' => 'nullable|string',
            'fileCategory' => 'required|string|max:50',
            'fileUpload' => 'required|file|max:20480', // 20MB max
        ]);
        
        $file = $request->file('fileUpload');
        $userId = auth()->id();
        
        // Determinar si es una imagen
        $isImage = strpos($file->getMimeType(), 'image/') === 0;
        
        // Generar un nombre único para el archivo
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        
        // Determinar la ruta de almacenamiento
        $path = $isImage ? 'images' : 'files';
        
        // Mover el archivo al almacenamiento público, no al privado
        // Usando el disco 'public' directamente para garantizar que sea accesible públicamente
        $filePath = $file->storeAs($path, $fileName, 'public');
        
        // Guardar en la base de datos con la ruta correcta
        UserFile::create([
            'user_id' => $userId,
            'title' => $request->fileTitle,
            'description' => $request->fileDescription,
            'filename' => $file->getClientOriginalName(),
            'file_path' => "storage/{$path}/{$fileName}", // Esta sigue siendo la ruta pública para acceso desde web
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'file_ext' => $file->getClientOriginalExtension(),
            'category' => $request->fileCategory,
            'is_image' => $isImage,
            'display_order' => $isImage ? UserFile::where('user_id', $userId)->where('is_image', true)->count() + 1 : 0,
        ]);
        
        // Redireccionar a la vista apropiada
        if ($isImage) {
            return redirect()->route('files.images')->with('success', 'Imagen subida correctamente.');
        } else {
            return redirect()->route('files.index')->with('success', 'Archivo subido correctamente.');
        }
    }

    /**
     * Descargar un archivo.
     */
    public function download($id)
    {
        $file = UserFile::findOrFail($id);
        $userId = auth()->id();
        
        // Verificar que el usuario actual sea el propietario del archivo
        if ($file->user_id !== $userId) {
            // Si no es el propietario, comprobar permisos adicionales
            abort(403, 'No tienes permiso para descargar este archivo.');
        }
        
        // Incrementar el contador de descargas
        $file->increment('downloads');
        
        // Extraer la ruta relativa al disco 'public'
        $path = str_replace('storage/', '', $file->file_path);
        
        // Ruta completa al archivo físico
        $fullPath = storage_path('app/public/' . $path);
        
        // Comprobar si el archivo existe
        if (!file_exists($fullPath)) {
            return back()->with('error', 'Lo sentimos, el archivo solicitado no existe o no está disponible.');
        }
        
        return response()->download($fullPath, $file->filename);
    }

    /**
     * Eliminar un archivo.
     */
    public function delete($id)
    {
        $file = UserFile::findOrFail($id);
        $userId = auth()->id();
        
        // Verificar que el usuario actual sea el propietario del archivo
        if ($file->user_id !== $userId) {
            // Si no es el propietario, comprobar permisos adicionales 
            abort(403, 'No tienes permiso para eliminar este archivo.');
        }
        
        // Extraer la ruta relativa al disco 'public'
        $path = str_replace('storage/', '', $file->file_path);
        
        // Eliminar el archivo del sistema de archivos si existe
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        
        // Eliminar el registro de la base de datos
        $file->delete();
        
        return redirect()->back()->with('success', 'Archivo eliminado correctamente.');
    }

    /**
     * Marcar/desmarcar un archivo como favorito.
     */
    public function toggleFavorite($id)
    {
        $file = UserFile::findOrFail($id);
        
        // Verificar que el usuario actual sea el propietario del archivo
        if ($file->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para modificar este archivo.');
        }
        
        // Cambiar el estado de favorito
        $file->is_favorite = !$file->is_favorite;
        $file->save();
        
        return redirect()->back()->with('success', 'Preferencia actualizada correctamente.');
    }
}
