<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\ProductUrlTrait;
use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Statamic\Contracts\Data\Augmentable;
use Statamic\Data\HasAugmentedData;

class Product extends ButikModel implements Augmentable
{
    use ProductUrlTrait;
    use HasAugmentedData;

    public    $incrementing = false;
    protected $table        = 'butik_products';
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'available'       => 'boolean',
        'description'     => 'array',
        'images'          => 'array',
        'price'           => 'integer',
        'stock'           => 'integer',
        'stock_unlimited' => 'boolean',
    ];

    protected $appends = [
        'show_url',
    ];

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A Product has taxes
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id', 'slug');
    }

    /**
     * A Product has categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'butik_category_product');
    }

//    public function getImagesAttribute()
//    {
//        return $this->augmentedValue('images')->value();
//    }

    /**
     * A Product has a shipping relation
     */
    public function shippingProfile()
    {
        return $this->belongsTo(ShippingProfile::class, 'shipping_profile_slug', 'slug');
    }

    /**
     * A Product has variants
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    /**
     * The product will return the belonging variant. Null will be returned,
     * in case a variant can't be connected to the given slug
     */
    public function getVariant(String $variantTitle)
    {
        return $this->variants->where('original_title', $variantTitle)->first();
    }

    /**
     * Will check if a variant with the given title does exist,
     * related to this product.
     */
    public function variantExists($title): bool
    {
        return $this->variants->contains('original_title', $title);
    }

    /**
     * Do variants exsist?
     */
    public function hasVariants()
    {
        return $this->variants->count() !== 0;
    }

    /**
     * Will return the base price for this item
     */
    public function getPriceAttribute($value)
    {
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
     * Will return the shipping price
     */
    public function getTaxPercentageAttribute()
    {
        return $this->tax->percentage;
    }

    public function getTaxAmountAttribute()
    {
        $tax   = $data = str_replace(',', '.', $this->tax->percentage);
        $price = (int)$this->getRawOriginal('price');
        $total = $price * ($tax / (100 + $tax));

        return $this->makeAmountHuman(round($total, 2));
    }

    /**
     * Is the product still in stock?
     */
    public function getSoldOutAttribute()
    {
        if ($this->stock_unlimited) {
            return false;
        }
        return $this->stock == 0;
    }

    /**
     * Return the price with currency appended
     */
    public function getCurrencyAttribute()
    {
        return config('butik.currency_symbol');
    }

    public function blueprint()
    {
        $blueprint = new ProductBlueprint();
        return $blueprint();
    }

    public function augmentedArrayData()
    {
        return $this->attributesToArray();
    }
}
