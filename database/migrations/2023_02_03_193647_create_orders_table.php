<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code_sale',50);
            $table->string('name_sale');
            $table->string('sequence');
            $table->string('invoice_address');
            $table->string('delivery_address');
            $table->string('delivery_time');
            $table->string('delivery_instructions');
            $table->string('order_date');
            $table->string('incidence');
            $table->string('sample_required');
            $table->decimal('additional_information',12,2);
            $table->string('tariff');
            $table->string('commercial_name');
            $table->string('commercial_email');
            $table->string('commercial_odoo_id');
            $table->string('subtotal');
            $table->string('taxes');
            $table->string('status_id');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code_sale',50);
            $table->string('type_purchase');
            $table->string('sequence');
            $table->string('company');
            $table->string('code_purchase');
            $table->string('order_date');
            $table->string('provider_name');
            $table->string('provider_address');
            $table->string('planned_date');
            $table->string('supplier_representative');
            $table->decimal('total',12,2);
            $table->string('status');
            $table->string('invoice')->nullable();
            $table->string('xml')->nullable();
            $table->string('payment_status')->nullable();
            $table->foreignId('sales_order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('odoo_product_id');
            $table->string('product');
            $table->string('description');
            $table->string('planned_date');
            $table->string('company');
            $table->string('quantity');
            $table->string('quantity_delivered');
            $table->string('quantity_invoiced');
            $table->string('measurement_unit');
            $table->string('unit_price');
            $table->string('subtotal');
            $table->foreignId('pucharse_order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
