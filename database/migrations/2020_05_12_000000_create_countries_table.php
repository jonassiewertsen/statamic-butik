<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('butik_countries', function (Blueprint $table) {
            $table->string('slug')->unique()->primary();
            $table->string('name');
            $table->string('iso');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_countries');
    }
}
