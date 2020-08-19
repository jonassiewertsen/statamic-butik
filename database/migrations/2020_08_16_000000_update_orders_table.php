<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('failed_at', 'authorized_at');
        });

        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('shipped_at', 'completed_at');
        });

        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('transaction_id', 'number');
        });

        Schema::table('butik_orders', function (Blueprint $table) {
            $table->json('shippings')->nullable()->after('total_amount');
            $table->timestamp('expired_at')->nullable()->after('completed_at');
            $table->timestamp('canceled_at')->nullable()->after('expired_at');
            $table->string('method')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('authorized_at', 'failed_at');
        });

        Schema::table('butik_orders', function (Blueprint $table) {
            $table->renameColumn('completed_at', 'shipped_at');
        });

        Schema::table('butik_orders', function (Blueprint $table) {
            $table->dropColumn('expired_at', 'canceled_at', 'total_amount');
        });
    }
}
