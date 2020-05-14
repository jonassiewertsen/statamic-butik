<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingTypesTable extends Migration
{
    public function up()
    {
        Schema::create('butik_shipping_types', function (Blueprint $table) {
            $table->string('slug')->unique()->primary();
            $table->string('title');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_shipping_types');
    }
}
