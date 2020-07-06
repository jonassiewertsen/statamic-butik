<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

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
      //
    ];

    protected $guarded = [];

    /**
     * A variant belongs to a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The title does contain of the parent name in combination with the variant title.
     * Fx.: Red Shirt - Large
     */
    public function getTitleAttribute()
    {
        return $this->product->title . ' - ' . $this->getRawOriginal('title');
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

        return $this->makeAmountHuman($value);
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
}
