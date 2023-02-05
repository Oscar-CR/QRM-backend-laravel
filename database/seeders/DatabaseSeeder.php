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
            'rfc' => '12345678910',
        ]);

        Companies::create([
            'social_reason' => 'PROMO LIFE S DE RL DE CV',
            'rfc' => '12345678910',
        ]);

        
        User::create([
            'fullname' => 'Oscar Chavez Rosales ',
            'rfc' => '123456789012',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => '',
            'status_id'=>1,
            'company_id'=>1,
        ])->attachRole($admin); 

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
