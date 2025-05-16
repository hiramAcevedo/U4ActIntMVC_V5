<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpleFileController extends Controller
{
    /**
     * Muestra la lista de archivos básica
     */
    public function files()
    {
        $userId = Auth::id();
        $files = UserFile::where('user_id', $userId)
                        ->where('is_image', false)
                        ->get();
        
        return view('files.simple-files', [
            'files' => $files
        ]);
    }
    
    /**
     * Muestra la lista de imágenes básica
     */
    public function images()
    {
        $userId = Auth::id();
        $images = UserFile::where('user_id', $userId)
                        ->where('is_image', true)
                        ->get();
        
        return view('files.simple-images', [
            'images' => $images
        ]);
    }
}
