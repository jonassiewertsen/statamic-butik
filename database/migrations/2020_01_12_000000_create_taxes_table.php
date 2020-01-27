<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    public function up()
    {
        Schema::create('butik_taxes', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique()->primary();
            $table->integer('percentage');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_taxes');
    }
}
