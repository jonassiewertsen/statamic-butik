<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProductsColumnToItems extends Migration
{
    public function up()
    {
        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('products', 'itmes');
        });
    }

    public function down()
    {
        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('items', 'products');
        });
    }
}
