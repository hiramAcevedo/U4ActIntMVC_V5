<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        
        // Crear permisos básicos (puedes expandir esto según necesites)
        $permissions = [
            'view_dashboard',
            'manage_files',
            'manage_users',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Asignar todos los permisos al rol admin
        $adminRole->givePermissionTo(Permission::all());
        
        // Asignar permisos limitados al rol user
        $userRole->givePermissionTo(['view_dashboard', 'manage_files']);
    }
}
