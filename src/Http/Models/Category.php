<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Illuminate\Support\Facades\DB;

class Category extends ButikModel
{
    protected $table = 'butik_categories';
    protected $primaryKey = 'slug';
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Will fetch all related products.
     */
    public function getProductsAttribute()
    {
        $products = collect();

        $results = DB::table('butik_category_product')
            ->where(['category_slug' => $this->slug])
            ->get();

        $results->each(function ($result) use ($products) {
            $products->push(Product::find($result->product_slug));
        });

        return $products;
    }

    /**
     * Add a product to this category.
     */
    public function addProduct(string $slug): void
    {
        DB::table('butik_category_product')
            ->insert([
                'category_slug' => $this->slug,
                'product_slug'  => $slug,
            ]);
    }

    /**
     * Add a product to this category.
     */
    public function removeProduct(string $product): void
    {
        DB::table('butik_category_product')
            ->where([
                'category_slug' => $this->slug,
                'product_slug'  => $product,
            ])->delete();
    }

    /**
     * Is a specific product attached to this category?
     */
    public function isProductAttached($product): bool
    {
        return DB::table('butik_category_product')
                ->where('product_slug', $product)
                ->where('category_slug', $this->slug)
                ->count() === 1;
    }

    /**
     * The url of the specific category.
     */
    public function getUrlAttribute()
    {
        return route('butik.shop.category', $this->slug, false);
    }
}
