<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProducts extends Migration
{
    public function up()
    {
        Schema::dropIfExists('butik_products');
    }

    public function down()
    {
        Schema::create('butik_products', function (Blueprint $table) {
            $table->boolean('available')->default(true);
            $table->integer('price');
            $table->json('description')->nullable();
            $table->json('images')->nullable();
            $table->string('shipping_profile_slug');
            $table->string('slug')->unique()->primary();
            $table->integer('stock')->default(0);
            $table->boolean('stock_unlimited')->default(false);
            $table->string('tax_id');
            $table->string('title');
            $table->string('type', 20)->default('physical');

            $table->timestamps();
        });
    }
}