<?php

namespace App\Services;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    /**
     * Genera un PDF con la información del usuario
     *
     * @param int $userId
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateUserPdf($userId)
    {
        $user = User::with('files')->findOrFail($userId);
        
        $data = [
            'user' => $user,
            'totalFiles' => $user->files()->count(),
            'totalImages' => $user->files()->where('is_image', true)->count(),
            'totalDocuments' => $user->files()->where('is_image', false)->count(),
            'totalFavorites' => $user->files()->where('is_favorite', true)->count(),
            'date' => now()->format('d/m/Y H:i')
        ];
        
        $pdf = PDF::loadView('exports.user-pdf', $data);
        return $pdf;
    }
    
    /**
     * Genera un PDF con la lista de usuarios
     *
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateUsersList()
    {
        $users = User::all();
        
        $data = [
            'users' => $users,
            'date' => now()->format('d/m/Y H:i')
        ];
        
        $pdf = PDF::loadView('exports.users-list-pdf', $data);
        return $pdf;
    }
} 