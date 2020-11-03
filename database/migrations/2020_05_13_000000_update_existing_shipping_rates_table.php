<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExistingShippingRatesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('butik_shipping_rates')) {
            Schema::table('butik_shipping_rates', function (Blueprint $table) {
                $table->unsignedBigInteger('shipping_zone_id')->change();

                $table->foreign('shipping_zone_id')
                    ->references('id')
                    ->on('butik_shipping_zones')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('butik_shipping_rates');
    }
}
