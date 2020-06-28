<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameShippingRelationOnProductsTable extends Migration
{
    public function up()
    {
        Schema::table('butik_products', function (Blueprint $table) {
            $table->renameColumn('shipping_id', 'shipping_profile_slug');
        });
    }

    public function down()
    {
        Schema::table('butik_products', function (Blueprint $table) {
            $table->renameColumn('shipping_profile_slug', 'shipping_id');
        });
    }
}
