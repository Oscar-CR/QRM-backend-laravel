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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('providers_companies', function (Blueprint $table) {
            $table->id();
            $table->string('social_reason');
            $table->string('rfc')->nullable();
            $table->timestamps();
        });

        Schema::create('local_companies', function (Blueprint $table) {
            $table->id();
            $table->string('social_reason');
            $table->string('rfc')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('rfc',15)->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->string('provider_company')->nullable();
            $table->integer('local_company_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('status');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('local_companies');
        Schema::dropIfExists('users');
    }
};
