<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('percentage');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('taxes');
    }
}
