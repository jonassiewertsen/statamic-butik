<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryProductTable extends Migration
{
    /**
     * SQLite only supports foreign keys upon creation of the table and not when tables are altered.
     * https://laravel.com/docs/7.x/migrations#foreign-key-constraints
     *
     * To be safe, we will create a temporary table, copy all variants into that table
     * and replace the temporary table with the butik_variants table.
     */
    public function up()
    {
        Schema::create('butik_category_product_temp', function (Blueprint $table) {
            $table->string('category_slug');
            $table->string('product_slug');

            $table->primary(['category_slug', 'product_slug']);

            $table->foreign('category_slug')->references('slug')->on('butik_categories')->onDelete('cascade');
        });

        DB::table('butik_category_product_temp')
            ->insert(DB::table('butik_category_product')->get()->map(function ($item) {
                return [
                    'category_slug' => $item->category_slug,
                    'product_slug'  => $item->product_slug,
                ];
            })->toArray());

        Schema::dropIfExists('butik_category_product');

        Schema::rename('butik_category_product_temp', 'butik_category_product');
    }

    public function down()
    {
        Schema::table('butik_category_product_temp', function (Blueprint $table) {
            $table->foreign('product_slug')
                ->references('slug')
                ->on('butik_products')
                ->onDelete('cascade');
        });
    }
}
