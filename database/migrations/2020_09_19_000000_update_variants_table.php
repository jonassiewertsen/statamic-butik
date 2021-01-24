<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;

class UpdateVariantsTable extends Migration
{
    /**
     * SQLite only supports foreign keys upon creation of the table and not when tables are altered.
     * https://laravel.com/docs/7.x/migrations#foreign-key-constraints.
     *
     * To be safe, we will create a temporary table, copy all variants into that table
     * and replace the temporary table with the butik_variants table.
     */
    public function up()
    {
        Schema::create('butik_variants_temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_slug');
            $table->boolean('preselected')->default(false);
            $table->string('title', 50);
            $table->boolean('available')->default(true);
            $table->boolean('inherit_price')->default(true);
            $table->integer('price')->unsigned()->nullable();
            $table->boolean('inherit_stock')->default(false);
            $table->integer('stock')->nullable();
            $table->boolean('stock_unlimited')->default(false);
            $table->timestamps();

            $table->unique(['product_slug', 'title']);
        });

        DB::table('butik_variants_temp')->insert(Variant::all()->map(function ($variant) {
            return [
                'id'              => $variant->id,
                'product_slug'    => $variant->product_slug,
                'preselected'     => $variant->preselected,
                'title'           => $variant->title,
                'available'       => $variant->available,
                'inherit_price'   => $variant->inherit_price,
                'price'           => $variant->price,
                'inherit_stock'   => $variant->inherit_stock,
                'stock'           => $variant->stock,
                'stock_unlimited' => $variant->stock_unlimited,
                'created_at'      => $variant->created_at,
                'updated_at'      => $variant->updated_at,
            ];
        })->toArray());

        Schema::dropIfExists('butik_variants');

        Schema::rename('butik_variants_temp', 'butik_variants');
    }

    public function down()
    {
        Schema::table('butik_variants', function (Blueprint $table) {
            $table->foreign('product_slug')
                ->references('slug')
                ->on('butik_products')
                ->onDelete('cascade');
        });
    }
}
