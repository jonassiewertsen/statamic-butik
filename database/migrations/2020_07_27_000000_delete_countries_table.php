<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteCountriesTable extends Migration
{
    public function up()
    {
        Schema::drop('butik_countries');
    }

    public function down()
    {
        Schema::create('butik_countries', function (Blueprint $table) {
            $table->string('slug')->unique()->primary();
            $table->string('name');
            $table->string('iso');

            $table->timestamps();
        });
    }
}
