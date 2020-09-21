<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;

use Statamic\Support\Str;

class Variant extends ButikModel
{
    use MoneyTrait;

    protected $table = 'butik_variants';

    protected $casts = [
        'available'       => 'boolean',
        'inherit_stock'   => 'boolean',
        'inherit_price'   => 'boolean',
        'price'           => 'integer',
        'stock'           => 'integer',
        'stock_unlimited' => 'boolean',
    ];

    protected $appends = [
      'slug',
      'original_title',
      'original_price',
      'original_stock',
      'original_stock_unlimited',
    ];

    protected $guarded = [];

    /**
     * A variant belongs to a product
     */
    public function getProductAttribute()
    {
        return Product::find($this->product_slug);
    }

    /**
     * The title does contain of the parent name in combination with the variant title.
     * Fx.: Red Shirt - Large
     */
    public function getTitleAttribute()
    {
        return $this->product->title . ' // ' . $this->getRawOriginal('title');
    }

    /**
     * The original is without the parent extension.
     * Fx.: Large
     */
    public function getOriginalTitleAttribute()
    {
        return $this->getRawOriginal('title');
    }

    /**
     * Will return the original price for this variant
     */
    public function getOriginalPriceAttribute($value)
    {
        return $this->makeAmountHuman($this->getRawOriginal('price'));
    }

    /**
     * Will return the price repecting the inheritance
     */
    public function getPriceAttribute($value)
    {
        if ($this->inherit_price) {
            return $this->product->price;
        }

        return $this->makeAmountHuman($this->getRawOriginal('price'));
    }

    /**
     * Mutating from a the correct amount into a integer without commas
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $this->makeAmountSaveable($value);
    }

    /**
     * Will return the original price for this variant
     */
    public function getOriginalStockAttribute($value)
    {
        return $this->getRawOriginal('stock');
    }

    /**
     * Will return the price repecting the inheritance
     */
    public function getStockAttribute($value)
    {
        if ($this->inherit_stock) {
            return $this->product->stock;
        }

        return $this->getRawOriginal('stock');
    }

    /**
     * Will return the original price for this variant
     */
    public function getOriginalStockUnlimitedAttribute($value)
    {
        return $this->getRawOriginal('stock_unlimited');
    }

    /**
     * Will return the original price for this variant
     */
    public function getStockUnlimitedAttribute($value)
    {
        if ($this->inherit_stock) {
            return $this->product->stock_unlimited;
        }

        return $this->getRawOriginal('stock_unlimited');
    }

    /**
     * A variant has a show url
     */
    public function getShowUrlAttribute()
    {
        $route = "{$this->shopRoute()}/{$this->product_slug}/{$this->original_title}";
        return Str::of($route)->start('/');
    }

    /**
     * A variant has a slug
     */
    public function getSlugAttribute()
    {
        return "{$this->product_slug}::{$this->id}";
    }

    /**
     * It inherits the tax from it's parent
     */
    public function getTaxAttribute()
    {
        return $this->product->tax;
    }

    /**
     * It inherits the shipping profile from it's parent
     */
    public function getShippingProfileAttribute()
    {
        return $this->product->shippingProfile;
    }

    /**
     * It inherits the images from it's parent
     */
    public function getImagesAttribute()
    {
        return $this->product->images;
    }
}
