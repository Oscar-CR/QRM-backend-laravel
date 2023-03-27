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
        Schema::create('payment_status', function (Blueprint $table) {
            $table->id();
            $table->string('description',50);
            $table->timestamps();
        });

        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code_sale',50);
            $table->string('name_sale');
            $table->string('sequence')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('delivery_instructions')->nullable();
            $table->string('order_date');
            $table->string('incidence')->nullable();
            $table->string('sample_required')->nullable();
            $table->string('additional_information')->nullable();
            $table->string('tariff');
            $table->string('commercial_name')->nullable();
            $table->string('commercial_email')->nullable();
            $table->string('commercial_odoo_id')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('taxes')->nullable();
            $table->string('total')->nullable();
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
            $table->foreignId('payment_status')->references('id')->on('payment_status')->nullable()->constrained();
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
        Schema::dropIfExists('order_status');
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
