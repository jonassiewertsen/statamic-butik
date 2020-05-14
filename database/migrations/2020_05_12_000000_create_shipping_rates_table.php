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
            $table->string('name');
            $table->integer('price');
            $table->integer('minimum');
            $table->integer('maximum');
            $table->string('type')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_shipping_rates');
    }
}
