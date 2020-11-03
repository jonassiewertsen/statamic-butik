<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendShippingZonesTable extends Migration
{
    public function up()
    {
        Schema::table('butik_shipping_zones', function (Blueprint $table) {
            $table->string('tax_slug')->nullable();
        });
    }

    public function down()
    {
        Schema::table('butik_shipping_zones', function (Blueprint $table) {
            $table->removeColumn('tax_slug');
        });
    }
}
