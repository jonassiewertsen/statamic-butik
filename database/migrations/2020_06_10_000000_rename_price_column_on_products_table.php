<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePriceColumnOnProductsTable extends Migration
{
    public function up()
    {
        Schema::table('butik_products', function (Blueprint $table) {
            $table->renameColumn('base_price', 'price');
        });
    }

    public function down()
    {
        Schema::table('butik_products', function (Blueprint $table) {
            $table->renameColumn('price', 'base_price');
        });
    }
}
