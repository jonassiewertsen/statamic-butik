<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingRatesTable extends Migration
{
    public function up()
    {
        Schema::create('butik_shipping_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shipping_zone_slug')->index();
            $table->string('title');
            $table->integer('price');
            $table->integer('minimum');
            $table->integer('maximum');
            $table->string('type')->default('price');

            $table->timestamps();

            $table->foreign('shipping_zone_slug')->references('slug')->on('butik_shipping_zones');
        });
    }

    public function down()
    {
        Schema::drop('butik_shipping_rates');
    }
}
