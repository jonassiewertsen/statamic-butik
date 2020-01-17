<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique()->primary();
            $table->integer('base_price');
            $table->bigInteger('taxes_id');
            $table->json('description')->nullable();
            $table->json('images')->nullable();
            $table->string('type', 20)->default('physical');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('products');
    }
}
