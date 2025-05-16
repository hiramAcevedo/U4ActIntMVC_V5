<?php

namespace App\Services;

use App\Models\User;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class WordService
{
    /**
     * Genera un documento Word con la información del usuario
     *
     * @param int $userId
     * @return string Ruta temporal del archivo
     */
    public function generateUserWord($userId)
    {
        $user = User::with('files')->findOrFail($userId);
        
        // Inicializar PHPWord
        $phpWord = new PhpWord();
        
        // Añadir estilos
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'color' => '333333']);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14, 'color' => '666666']);
        
        // Crear una sección
        $section = $phpWord->addSection();
        
        // Título
        $section->addTitle('Informe de Usuario', 1);
        $section->addTextBreak();
        
        // Información del usuario
        $section->addTitle('Datos Personales', 2);
        $table = $section->addTable(['borderSize' => 1, 'borderColor' => '999999']);
        
        $table->addRow();
        $table->addCell(2000)->addText('ID');
        $table->addCell(6000)->addText($user->id);
        
        $table->addRow();
        $table->addCell(2000)->addText('Nombre');
        $table->addCell(6000)->addText($user->name);
        
        $table->addRow();
        $table->addCell(2000)->addText('Email');
        $table->addCell(6000)->addText($user->email);
        
        $table->addRow();
        $table->addCell(2000)->addText('Fecha Registro');
        $table->addCell(6000)->addText($user->created_at->format('d/m/Y H:i'));
        
        $section->addTextBreak();
        
        // Resumen de archivos
        $section->addTitle('Resumen de Archivos', 2);
        $table = $section->addTable(['borderSize' => 1, 'borderColor' => '999999']);
        
        $table->addRow();
        $table->addCell(3000)->addText('Total Archivos');
        $table->addCell(3000)->addText($user->files()->count());
        
        $table->addRow();
        $table->addCell(3000)->addText('Imágenes');
        $table->addCell(3000)->addText($user->files()->where('is_image', true)->count());
        
        $table->addRow();
        $table->addCell(3000)->addText('Documentos');
        $table->addCell(3000)->addText($user->files()->where('is_image', false)->count());
        
        $table->addRow();
        $table->addCell(3000)->addText('Favoritos');
        $table->addCell(3000)->addText($user->files()->where('is_favorite', true)->count());
        
        $section->addTextBreak();
        
        // Listado de archivos
        if ($user->files->count() > 0) {
            $section->addTitle('Listado de Archivos', 2);
            $table = $section->addTable(['borderSize' => 1, 'borderColor' => '999999']);
            
            // Cabecera
            $table->addRow();
            $table->addCell(1000)->addText('ID', ['bold' => true]);
            $table->addCell(3000)->addText('Título', ['bold' => true]);
            $table->addCell(2000)->addText('Tipo', ['bold' => true]);
            $table->addCell(2000)->addText('Tamaño', ['bold' => true]);
            $table->addCell(1000)->addText('Favorito', ['bold' => true]);
            
            // Filas de datos
            foreach ($user->files as $file) {
                $table->addRow();
                $table->addCell(1000)->addText($file->id);
                $table->addCell(3000)->addText($file->title);
                $table->addCell(2000)->addText($file->is_image ? 'Imagen' : 'Documento');
                $table->addCell(2000)->addText(number_format($file->file_size / 1024, 2) . ' KB');
                $table->addCell(1000)->addText($file->is_favorite ? 'Sí' : 'No');
            }
        }
        
        // Pie de página
        $section->addTextBreak();
        $footer = $section->addFooter();
        $footer->addText('Documento generado el ' . now()->format('d/m/Y H:i'), ['size' => 8], ['alignment' => Jc::CENTER]);
        
        // Guardar en archivo temporal
        $filename = 'usuario_' . $user->id . '_' . time() . '.docx';
        $tempPath = storage_path('app/public/temp/' . $filename);
        
        // Asegurar que la carpeta temp exista
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }
        
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);
        
        return $tempPath;
    }
} 