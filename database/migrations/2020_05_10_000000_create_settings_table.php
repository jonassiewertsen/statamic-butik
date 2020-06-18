<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('butik_settings', function (Blueprint $table) {
            $table->string('key')->unique()->primary();
            $table->string('value');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_settings');
    }
}
