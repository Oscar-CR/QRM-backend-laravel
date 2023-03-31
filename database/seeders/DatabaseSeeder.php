<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Companies;
use App\Models\LocalCompanies;
use App\Models\PaymentStatus;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
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
        /* ---------------- ROLES ---------------- */
       
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'administrador', // optional
            'description' => '', // optional
        ]);
        $provider = Role::create([
            'name' => 'provider',
            'display_name' => 'proveedor', // optional
            'description' => '', // optional
        ]);
        $billtopay = Role::create([
            'name' => 'billtopay',
            'display_name' => 'cuentas por pagar', // optional
            'description' => '', // optional
        ]);
        $visualizer = Role::create([
            'name' => 'visualizer',
            'display_name' => 'visualizador', // optional
            'description' => '', // optional
        ]);

        /*  ---------------- STATUS DE USUARIO ---------------- */

        Status::create([
            'name' => 'activo',
            'description' => 'usuario activo en sistema',
        ]);

        Status::create([
            'name' => 'baja',
            'description' => 'usuario dado de baja activo',
        ]);

        /* ---------------- ENPRESAS Y PROVEEDORES ---------------- */

        
        LocalCompanies::create([
            'social_reason' => 'BH TRADE MARKET SA DE CV',
            'rfc' => '0987654321',
        ]);

        LocalCompanies::create([
            'social_reason' => 'PROMO LIFE S DE RL DE CV',
            'rfc' => '1234123412',
        ]);

        LocalCompanies::create([
            'social_reason' => 'TRADE MARKET 57',
            'rfc' => '0987654321',
        ]);
        
        /* ---------------- USUARIOS  ----------------*/
        
        User::create([
            'fullname' => 'Nombre Administrador',
            'rfc' => '123456789012',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'local_company_id'=>1,
            'provider_company'=>null,
        ])->attachRole($admin); 

        User::create([
            'fullname' => 'Nombre Administrador 2',
            'rfc' => '35467869756',
            'email' => 'admin2@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'local_company_id'=>1,
            'provider_company'=>null,
        ])->attachRole($admin); 


        User::create([
            'fullname' => 'Nombre Cuentas por pagar',
            'rfc' => '1122334455',
            'email' => 'billtopay@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'local_company_id'=>1,
            'provider_company'=>null,
        ])->attachRole($billtopay); 

        User::create([
            'fullname' => 'Nombre Visualizador',
            'rfc' => '9988776655',
            'email' => 'visualizer@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'local_company_id'=>1,
            'provider_company'=>null,
        ])->attachRole($visualizer); 

        PaymentStatus::create([
            'id' => 1,
            'description' => 'En validación',
        ]);

        PaymentStatus::create([
            'id' => 2,
            'description' => 'Validado',
        ]);

        PaymentStatus::create([
            'id' => 3,
            'description' => 'Por pagar',
        ]);

        PaymentStatus::create([
            'id' => 4,
            'description' => 'Pagado',
        ]);

    }


}
