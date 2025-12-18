<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CategoryProductSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        $this->command->info('¡La base de datos fue llenada exitosamente!');
    }
}
