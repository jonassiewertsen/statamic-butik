<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('butik_orders', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('transaction_id');
            $table->string('status');
            $table->string('method');
            $table->json('products');
            $table->json('customer');
            $table->integer('total_amount');
            $table->timestamp('paid_at')->default(null)->nullable();
            $table->timestamp('failed_at')->default(null)->nullable();
            $table->timestamp('shipped_at')->default(null)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('butik_orders');
    }
}
