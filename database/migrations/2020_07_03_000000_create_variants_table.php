<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('butik_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_slug');
            $table->string('title', 50);
            $table->boolean('available')->default(true);
            $table->boolean('inherit_price')->default(true);
            $table->integer('price')->unsigned()->nullable();
            $table->boolean('inherit_stock')->default(false);
            $table->integer('stock')->nullable();
            $table->boolean('stock_unlimited')->default(false);
            $table->timestamps();

            $table->foreign('product_slug')
                ->references('slug')
                ->on('butik_products')
                ->onDelete('cascade');

            $table->unique(['product_slug', 'title']);
        });
    }

    public function down()
    {
        Schema::drop('butik_variants');
    }
}
