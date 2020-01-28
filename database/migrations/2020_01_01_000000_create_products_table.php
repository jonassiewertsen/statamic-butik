<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('butik_products', function (Blueprint $table) {
            $table->boolean('available')->default(true);
            $table->integer('base_price');
            $table->json('description')->nullable();
            $table->json('images')->nullable();
            $table->string('shipping_id');
            $table->string('slug')->unique()->primary();
            $table->integer('stock')->default(0);
            $table->boolean('stock_unlimited')->default(false);
            $table->string('tax_id');
            $table->string('title');
            $table->string('type', 20)->default('physical');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_products');
    }
}
