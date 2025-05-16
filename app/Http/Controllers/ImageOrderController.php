<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;

class ImageOrderController extends Controller
{
    /**
     * Actualiza el orden de las imágenes
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:user_files,id',
            'items.*.order' => 'required|integer|min:0',
        ]);
        
        // Verificar que las imágenes pertenecen al usuario actual
        $userId = auth()->id();
        $items = $request->items;
        
        // Actualizar el orden en la base de datos
        foreach ($items as $item) {
            $file = UserFile::where('id', $item['id'])
                          ->where('user_id', $userId)
                          ->first();
            
            if ($file) {
                $file->display_order = $item['order'];
                $file->save();
            }
        }
        
        return response()->json(['success' => true]);
    }
} 