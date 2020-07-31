<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShippingZonesTable extends Migration
{
    public function up()
    {
        Schema::table('butik_shipping_zones', function (Blueprint $table) {
            $table->json('countries')->nullable()->after('shipping_profile_slug');
        });
    }

    public function down()
    {
        Schema::table('butik_shipping_zones', function (Blueprint $table) {
            $table->removeColumn('countries');
        });
    }
}
