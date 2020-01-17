<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique()->primary();
            $table->integer('price');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('shippings');
    }
}
