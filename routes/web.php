<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta de prueba sin middleware
Route::get('/test', function () {
    return 'La ruta funciona correctamente';
});

// Rutas adicionales de prueba con funciones anónimas
Route::get('/prueba-files', function() {
    return 'Prueba de files con función anónima';
});

Route::get('/prueba-images', function() {
    return 'Prueba de images con función anónima';
});

// Rutas de prueba para files e images sin middleware de autenticación
Route::get('/test-files', [FileController::class, 'index']);
Route::get('/test-images', [FileController::class, 'images']);

// Rutas con el nuevo TestController
Route::get('/simple-files', [TestController::class, 'files']);
Route::get('/simple-images', [TestController::class, 'images']);

// Nuevas rutas con controlador simplificado
Route::middleware(['auth'])->group(function () {
    Route::get('/archivos', [App\Http\Controllers\SimpleFileController::class, 'files'])->name('simple.files');
    Route::get('/imagenes', [App\Http\Controllers\SimpleFileController::class, 'images'])->name('simple.images');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para archivos (movidas dentro del middleware nuevamente)
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::get('/images', [FileController::class, 'images'])->name('files.images');
    Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::get('/files/download/{id}', [FileController::class, 'download'])->name('files.download');
    Route::get('/files/delete/{id}', [FileController::class, 'delete'])->name('files.delete');
    Route::get('/files/favorite/{id}', [FileController::class, 'toggleFavorite'])->name('files.favorite');
    
    // Ruta para actualizar el orden de imágenes
    Route::post('/api/update-image-order', [App\Http\Controllers\ImageOrderController::class, 'updateOrder'])->name('api.images.updateOrder');

    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de administración
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/user/{id}', [AdminDashboardController::class, 'viewUser'])->name('admin.user.view');
    
    // Rutas de exportación
    Route::get('/export/users/excel', [AdminDashboardController::class, 'exportUsersExcel'])->name('admin.export.users.excel');
    Route::get('/export/users/pdf', [AdminDashboardController::class, 'exportUsersPdf'])->name('admin.export.users.pdf');
    Route::get('/export/user/{id}/excel', [AdminDashboardController::class, 'exportUserExcel'])->name('admin.export.user.excel');
    Route::get('/export/user/{id}/pdf', [AdminDashboardController::class, 'exportUserPdf'])->name('admin.export.user.pdf');
    Route::get('/export/user/{id}/word', [AdminDashboardController::class, 'exportUserWord'])->name('admin.export.user.word');
    Route::get('/export/user/{id}/zip', [AdminDashboardController::class, 'downloadUserZip'])->name('admin.export.user.zip');
});

// Ruta para mostrar directamente los archivos físicos
Route::get('/archivos-fisicos', function() {
    $imageFiles = [];
    $imagesDir = storage_path('app/public/images');
    
    if (is_dir($imagesDir)) {
        $files = scandir($imagesDir);
        
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $imageFiles[] = [
                    'filename' => $file,
                    'path' => '/storage/images/' . $file,
                    'size' => filesize($imagesDir . '/' . $file)
                ];
            }
        }
    }
    
    $documentFiles = [];
    $filesDir = storage_path('app/public/files');
    
    if (is_dir($filesDir)) {
        $files = scandir($filesDir);
        
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $documentFiles[] = [
                    'filename' => $file,
                    'path' => '/storage/files/' . $file,
                    'size' => filesize($filesDir . '/' . $file)
                ];
            }
        }
    }
    
    return view('files.physical', [
        'images' => $imageFiles,
        'documents' => $documentFiles
    ]);
});

require __DIR__.'/auth.php';
