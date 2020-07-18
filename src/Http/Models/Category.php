<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Support\Facades\DB;

class Category extends ButikModel
{
    protected $table      = 'butik_categories';
    protected $primaryKey = 'slug';
    protected $keyType    = 'string';

    protected $guarded = [];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'butik_category_product',
            'category_slug',
            'product_slug',
        );
    }

    /**
     * Add a product to this category
     */
    public function addProduct(Product $product): void
    {
        $this->products()->attach($product);
    }

    /**
     * Add a product to this category
     */
    public function removeProduct(Product $product): void
    {
        $this->products()->detach($product);
    }

    /**
     * Is a specific product attached to this category?
     */
    public function isProductAttached(Product $product): bool
    {
        return DB::table('butik_category_product')
                ->where('product_slug', $product->slug)
                ->where('category_slug', $this->slug)
                ->count() === 1;
    }

    /**
     * The url of the specific category
     */
    public function getUrlAttribute()
    {
        return route('butik.shop.category', $this);
    }
}
