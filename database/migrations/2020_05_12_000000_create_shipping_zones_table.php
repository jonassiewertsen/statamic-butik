<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingZonesTable extends Migration
{
    public function up()
    {
        Schema::create('butik_shipping_zones', function (Blueprint $table) {
            $table->string('slug')->unique()->primary();
            $table->string('name');
            $table->string('shipping_profile_slug')->nullable()->index();

            $table->timestamps();

            $table->foreign('shipping_profile_slug')->references('slug')->on('butik_shipping_profiles');
        });
    }

    public function down()
    {
        Schema::drop('butik_shipping_zones');
    }
}
