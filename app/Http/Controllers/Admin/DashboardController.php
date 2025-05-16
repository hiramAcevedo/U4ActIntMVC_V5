<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserFile;
use App\Exports\UsersExport;
use App\Services\PdfService;
use App\Services\WordService;
use App\Services\ZipService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard de administrador.
     */
    public function index()
    {
        // Obtener todos los usuarios, incluyendo el administrador
        $users = User::all();
        
        // Estadísticas generales
        $totalUsers = User::count();
        
        // Total de archivos de usuarios regulares (no admin)
        $regularUserFiles = UserFile::whereHas('user', function($query) {
            $query->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            });
        })->count();
        
        // Total de archivos incluyendo los del administrador
        $totalFiles = UserFile::count();
        
        return view('admin.dashboard', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'totalFiles' => $totalFiles,
            'regularUserFiles' => $regularUserFiles,
        ]);
    }

    /**
     * Ver detalles de un usuario específico.
     */
    public function viewUser($userId)
    {
        // Obtener información del usuario
        $user = User::findOrFail($userId);
        
        // Obtener archivos del usuario
        $files = $user->files;
        $totalFiles = $user->files()->count();
        $totalImages = $user->images()->count();
        $totalDownloads = $user->files()->sum('downloads');
        
        return view('admin.user-detail', [
            'user' => $user,
            'files' => $files,
            'totalFiles' => $totalFiles,
            'totalImages' => $totalImages,
            'totalDownloads' => $totalDownloads,
        ]);
    }

    /**
     * Exportar lista de usuarios a Excel
     */
    public function exportUsersExcel()
    {
        return Excel::download(new UsersExport(), 'usuarios.xlsx');
    }
    
    /**
     * Exportar información de un usuario específico a Excel
     */
    public function exportUserExcel($userId)
    {
        $filename = 'usuario_' . $userId . '.xlsx';
        return Excel::download(new UsersExport($userId), $filename);
    }
    
    /**
     * Exportar lista de usuarios a PDF
     */
    public function exportUsersPdf()
    {
        $pdfService = new PdfService();
        $pdf = $pdfService->generateUsersList();
        return $pdf->stream('usuarios.pdf');
    }
    
    /**
     * Exportar información de un usuario específico a PDF
     */
    public function exportUserPdf($userId)
    {
        $pdfService = new PdfService();
        $pdf = $pdfService->generateUserPdf($userId);
        return $pdf->stream('usuario_' . $userId . '.pdf');
    }
    
    /**
     * Exportar información de un usuario específico a Word
     */
    public function exportUserWord($userId)
    {
        $wordService = new WordService();
        $wordPath = $wordService->generateUserWord($userId);
        
        return response()->download($wordPath, 'usuario_' . $userId . '.docx')->deleteFileAfterSend(true);
    }
    
    /**
     * Generar y descargar un ZIP con todos los archivos de un usuario
     */
    public function downloadUserZip($userId)
    {
        $zipService = new ZipService();
        $zipPath = $zipService->generateUserZip($userId);
        
        return response()->download($zipPath, 'usuario_' . $userId . '_archivos.zip')->deleteFileAfterSend(true);
    }
}
