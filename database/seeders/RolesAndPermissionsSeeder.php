<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        /**
         * IMPORTANTE
         * Limpia la caché de permisos para evitar inconsistencias
         */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        /**
         * CREAR PERMISOS
         */

        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        /**
         * CREAR PERMISOS
         */
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        /**
         * ASIGNAR PERMISOS A ROLES
         */
        $adminRole->givePermissionTo(Permission::all());

        $editorRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
        ]);

        $viewerRole->givePermissionTo([
            'view products',
        ]);

        /**
         * CREAR USUARIOS
         */
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        $editorUser = User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            [
                'name' => 'Editor User',
                'password' => Hash::make('password'),
            ]
        );

        $viewerUser = User::firstOrCreate(
            ['email' => 'viewer@gmail.com'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
            ]
        );

        /**
         * ASIGNAR ROLES A USUARIOS
         */
        $adminUser->assignRole($adminRole);
        $editorUser->assignRole($editorRole);
        $viewerUser->assignRole($viewerRole);
    }
}
