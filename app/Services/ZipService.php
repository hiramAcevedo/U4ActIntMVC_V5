<?php

namespace App\Services;

use App\Models\User;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class ZipService
{
    /**
     * Genera un archivo ZIP con todos los archivos del usuario
     *
     * @param int $userId
     * @return string Ruta temporal del archivo
     */
    public function generateUserZip($userId)
    {
        $user = User::with('files')->findOrFail($userId);
        
        // Crear un nombre de archivo temporal para el ZIP
        $zipName = 'usuario_' . $user->id . '_archivos_' . time() . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipName);
        
        // Asegurar que la carpeta temp exista
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }
        
        // Crear el archivo ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception("No se pudo crear el archivo ZIP");
        }
        
        // Añadir archivos del usuario al ZIP
        foreach ($user->files as $file) {
            $filePath = str_replace('storage/', 'public/', $file->file_path);
            if (Storage::exists($filePath)) {
                $fileContent = Storage::get($filePath);
                $zip->addFromString($file->filename, $fileContent);
            }
        }
        
        // Generar también los informes (PDF, Excel, Word) y añadirlos al ZIP
        $this->addReportsToZip($zip, $user);
        
        // Cerrar el ZIP
        $zip->close();
        
        return $zipPath;
    }
    
    /**
     * Añade informes generados al ZIP
     *
     * @param ZipArchive $zip
     * @param User $user
     * @return void
     */
    protected function addReportsToZip(ZipArchive $zip, User $user)
    {
        // Añadir un informe PDF
        $pdfService = new PdfService();
        $pdf = $pdfService->generateUserPdf($user->id);
        $pdfContent = $pdf->output();
        $zip->addFromString('informes/informe_usuario_' . $user->id . '.pdf', $pdfContent);
        
        // Generar y añadir Word
        $wordService = new WordService();
        $wordPath = $wordService->generateUserWord($user->id);
        $wordContent = file_get_contents($wordPath);
        $zip->addFromString('informes/informe_usuario_' . $user->id . '.docx', $wordContent);
        
        // Eliminar archivos temporales
        @unlink($wordPath);
    }
} 