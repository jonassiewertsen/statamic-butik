<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('butik_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->primary();
            $table->string('name', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_categories');
    }
}
