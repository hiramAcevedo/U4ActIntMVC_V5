<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SampleFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar archivos físicos en storage/app/public/images
        $imagesDir = storage_path('app/public/images');
        
        if (is_dir($imagesDir)) {
            $files = File::files($imagesDir);
            
            // Obtener usuarios
            $admin = User::where('email', 'admin@example.com')->first();
            $testUser = User::where('email', 'test@example.com')->first();
            
            if (!$admin || !$testUser) {
                $this->command->error('No se encontraron usuarios. Por favor, ejecuta AdminUserSeeder primero.');
                return;
            }
            
            // Asignar archivos existentes a usuarios en la base de datos
            $count = 0;
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $size = $file->getSize();
                $extension = $file->getExtension();
                
                // Alternar entre admin y usuario regular
                $user = $count % 2 == 0 ? $admin : $testUser;
                
                // Crear registro en la base de datos
                UserFile::create([
                    'user_id' => $user->id,
                    'title' => "Imagen muestra " . ($count + 1),
                    'description' => "Esta es una imagen de muestra para demostración",
                    'filename' => $filename,
                    'file_path' => "storage/images/" . $filename,
                    'file_type' => 'image/' . $extension,
                    'file_size' => $size,
                    'file_ext' => $extension,
                    'category' => 'demo',
                    'is_image' => true,
                    'is_favorite' => $count % 3 == 0, // Cada tercer archivo será favorito
                    'display_order' => $count + 1,
                ]);
                
                $count++;
            }
            
            $this->command->info("Se han agregado $count archivos existentes a la base de datos.");
        } else {
            $this->command->error("El directorio de imágenes no existe: $imagesDir");
        }
    }
} 