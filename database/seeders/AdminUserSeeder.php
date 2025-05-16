<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Comprobar si el usuario admin ya existe
        $admin = User::where('email', 'admin@example.com')->first();
        
        if (!$admin) {
            // Crear usuario administrador
            $admin = User::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
            ]);
            
            // Asignar el rol de administrador
            $admin->assignRole('admin');
            
            $this->command->info('Usuario administrador creado con éxito.');
            $this->command->info('Email: admin@example.com');
            $this->command->info('Contraseña: admin123');
        } else {
            $this->command->info('El usuario administrador ya existe.');
        }
    }
}
