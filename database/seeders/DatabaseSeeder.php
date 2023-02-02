<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'administrador', // optional
            'description' => '', // optional
        ]);
        $admin = Role::create([
            'name' => 'provider',
            'display_name' => 'proveedor', // optional
            'description' => '', // optional
        ]);
        $admin = Role::create([
            'name' => 'billtopay',
            'display_name' => 'cuentas por pagar', // optional
            'description' => '', // optional
        ]);
        $admin = Role::create([
            'name' => 'visualizer',
            'display_name' => 'visualizador', // optional
            'description' => '', // optional
        ]);





    }
}
