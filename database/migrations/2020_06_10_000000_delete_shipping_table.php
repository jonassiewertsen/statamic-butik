<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteShippingTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('butik_shippings');
    }

    public function down()
    {
        Schema::create('butik_shippings', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique()->primary();
            $table->integer('price');

            $table->timestamps();
        });
    }
}
