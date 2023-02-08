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

        Companies::create([
            'social_reason' => 'EMPRESA 2 S.A DE C.V',
            'rfc' => '23422342234',
        ]);

        Companies::create([
            'social_reason' => 'EMPRESA 3 S.A DE C.V',
            'rfc' => '242342342',
        ]);
        /* ---------------- USUARIOS  ----------------*/
        
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

        /* ---------------- ORDENES Y PRODUCTOS  ----------------*/
        
        /* ORDEN 1 */
        Order::create([
            'code_sale' => 'ORDEN-01',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'BH TRADE MARKET SA DE CV',
            'code_purchase' => 'OC-11523',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2023-02-09 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 500.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'En validacion'
        ]);
        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-01',
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
            'odoo_product_id' => 'P02-01',
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
        
        
        /* ORDEN 2 */

        Order::create([
            'code_sale' => 'ORDEN-02',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'BH TRADE MARKET SA DE CV',
            'code_purchase' => 'OC-11223',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'EMPRESA 2 S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2023-02-08 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 1000.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'Pagado'
        ]);
        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-02',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '41323.36',
            'pucharse_order_id' => 2,
        ]);

        Product::create([
            'odoo_product_id' => 'P02-02',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '100.00',
            'pucharse_order_id' => 2,
        ]);

        Product::create([
            'odoo_product_id' => 'P03-02',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '100.00',
            'pucharse_order_id' => 2,
        ]);

        Product::create([
            'odoo_product_id' => 'P04-02',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '100.00',
            'pucharse_order_id' => 2,
        ]);

        /* ORDEN 3 */

        Order::create([
            'code_sale' => 'ORDEN-03.01',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'BH TRADE MARKET SA DE CV',
            'code_purchase' => 'OC-11223',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'EMPRESA 3 S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2023-02-09 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 300.15,
            'status' => 'Pedido de Compra',
            'payment_status' => 'Por pagar'
        ]);
        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-03.01',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '41323.36',
            'pucharse_order_id' => 3,
        ]);
        /* ORDEN 3-2 */
        Order::create([
            'code_sale' => 'ORDEN-03.02',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'BH TRADE MARKET SA DE CV',
            'code_purchase' => 'OC-11223',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'EMPRESA 3 S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2023-02-07 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 200.99,
            'status' => 'Pedido de Compra',
            'payment_status' => 'Por pagar'
        ]);
        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-03.02',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'BH TRADE MARKET SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '41323.36',
            'pucharse_order_id' => 4,
        ]);

        /* ORDER 1.2 */
        Order::create([
            'code_sale' => 'ORDEN-01.2',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'BH TRADE MARKET SA DE CV',
            'code_purchase' => 'OC-11523',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2024-09-15 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 500.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'En validacion'
        ]);

        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-01.2',
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
            'pucharse_order_id' => 5,
        ]);

         /* ORDER PROMOLIFE */
         Order::create([
            'code_sale' => 'ORDEN-PL',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'PROMO LIFE S DE RL DE CV',
            'code_purchase' => 'OC-11523',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2024-09-15 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 1212.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'En validacion'
        ]);

        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-01.2',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'PROMO LIFE S DE RL DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '47.43',
            'pucharse_order_id' => 6,
        ]);

         /* ORDER T57 */
         Order::create([
            'code_sale' => 'ORDEN-T57',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'TRADE MARKET 57 SA DE CV',
            'code_purchase' => 'OC-11523',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2024-09-15 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 1212.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'En validacion'
        ]);

        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-01.2',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'TRADE MARKET 57 SA DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '47.43',
            'pucharse_order_id' => 7,
        ]);

         /* ORDER EMPRESA2 */
         Order::create([
            'code_sale' => 'ORDEN-T57E2',
            'type_purchase' => 'Productos',
            'sequence' => 'COMPRAS PEDIDOS',
            'company' => 'PROMO LIFE S DE RL DE CV',
            'code_purchase' => 'OC-11523',
            'order_date' => '2020-09-14 14:31:42',
            'provider_name' => 'EMPRESA 2 S.A DE C.V',
            'provider_address' => 'AV. GUSTAVO ABAZ SUR N°8 LOMAS DE SAN AGUSTIN NAUCALPAN DE JUAREZ México (MX)53490 México',
            'planned_date' => '2024-09-15 14:31:37',
            'supplier_representative' => 'BRENDA RAMIREZ',
            'total' => 1212.36,
            'status' => 'Pedido de Compra',
            'payment_status' => 'En validacion'
        ]);

        /* PRODUCTO */
        Product::create([
            'odoo_product_id' => 'P01-01.2',
            'product' => '[T 87 BLANCO] CINTA PARA CONTROL DE LA MASA CORPORAL',
            'description' => 'CINTA PARA CONTROL DE LA MASA CORPORAL',
            'planned_date' => '2020-09-15 14:26:55',
            'company' => 'PROMO LIFE S DE RL DE CV',
            'quantity' => '3',
            'quantity_delivered' => '3',
            'quantity_invoiced' => '3',
            'measurement_unit' => '15.81',
            'unit_price' => '15.81',
            'subtotal' => '47.43',
            'pucharse_order_id' => 8,
        ]);
    }


}
