<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Companies;
use App\Models\Order;
use App\Models\Product;
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

        Status::create([
            'name' => 'activo',
            'description' => 'usuario activo en sistema',
        ]);

        Status::create([
            'name' => 'baja',
            'description' => 'usuario dado de baja activo',
        ]);

        Companies::create([
            'social_reason' => 'SIN ASIGNAR',
            'rfc' => 'SIN ASIGNAR',
        ]);
        
        Companies::create([
            'social_reason' => 'BH TRADE MARKET SA DE CV',
            'rfc' => '0987654321',
        ]);

        Companies::create([
            'social_reason' => 'PROMO LIFE S DE RL DE CV',
            'rfc' => '1234123412',
        ]);

        Companies::create([
            'social_reason' => 'TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V',
            'rfc' => '9876987654',
        ]);


        
        User::create([
            'fullname' => 'Oscar Chavez Rosales',
            'rfc' => '123456789012',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'company_id'=>1,
        ])->attachRole($admin); 

        User::create([
            'fullname' => 'Persona 2',
            'rfc' => '9876543210',
            'email' => 'proveedor@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'company_id'=>4,
        ])->attachRole($provider);

        User::create([
            'fullname' => 'Persona 3',
            'rfc' => '1122334455',
            'email' => 'billtopay@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'company_id'=>1,
        ])->attachRole($billtopay); 

        User::create([
            'fullname' => 'Persona 4',
            'rfc' => '9988776655',
            'email' => 'visualizer@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'company_id'=>1,
        ])->attachRole($visualizer); 

        Order::create([
            'code_sale' => 'PED-13701',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'BH TRADE MARKET SA DE CV',
            'code_purchase' => 'OC-11523',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2020-09-15 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 1242.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'En validacion'
        ]);

        Product::create([
            'odoo_product_id' => 'JIOE',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '47.43',
            'pucharse_order_id' => 1,
        ]);

        Product::create([
            'odoo_product_id' => '4343',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '47.43',
            'pucharse_order_id' => 1,
        ]);

    }
}
