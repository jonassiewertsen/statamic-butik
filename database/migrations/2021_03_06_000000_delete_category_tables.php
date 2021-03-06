<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeleteCategoryTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('butik_category_product');
        Schema::dropIfExists('butik_categories');
    }

    public function down()
    {
        Schema::create('butik_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->primary();
            $table->string('name', 50);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('butik_category_product', function (Blueprint $table) {
            $table->string('category_slug');
            $table->string('product_slug');

            $table->primary(['category_slug', 'product_slug']);

            $table->foreign('category_slug')->references('slug')->on('butik_categories')->onDelete('cascade');
        });
    }
}
