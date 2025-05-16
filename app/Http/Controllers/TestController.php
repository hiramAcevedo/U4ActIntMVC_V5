<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Test de funcionalidad básica
     */
    public function files()
    {
        return "Test de controlador para archivos - Sin autenticación";
    }

    /**
     * Test de funcionalidad básica para imágenes
     */
    public function images()
    {
        return "Test de controlador para imágenes - Sin autenticación";
    }
} 