<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryShippingZoneTable extends Migration
{
    public function up()
    {
        Schema::create('butik_country_shipping_zone', function (Blueprint $table) {
            $table->string('shipping_zone_slug')->nullable()->index();
            $table->string('country_slug')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::drop('butik_country_shipping_zone');
    }
}
