<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductTable extends Migration
{
    public function up()
    {
        Schema::create('butik_category_product', function (Blueprint $table) {
            $table->string('category_slug');
            $table->string('product_slug');

            $table->primary(['category_slug', 'product_slug']);

            $table->foreign('category_slug')->references('slug')->on('butik_categories')->onDelete('cascade');
            $table->foreign('product_slug')->references('slug')->on('butik_products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('butik_category_product');
    }
}
