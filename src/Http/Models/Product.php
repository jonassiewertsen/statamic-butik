<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Http\Traits\ProductUrlTrait;
use Statamic\Entries\EntryCollection;
use Statamic\Facades\Entry;

class Product
{
    use ProductUrlTrait;
    use MoneyTrait;

    protected const COLLECTION_NAME = 'products';
    public string  $slug;
    public bool    $available;

    public function all()
    {
        return $this->extend(Entry::whereCollection(self::COLLECTION_NAME));
    }

    public function find(string $slug)
    {
        $entry = Entry::findBySlug($slug, self::COLLECTION_NAME);

        // TODO: Refactor
        foreach ($entry->values() as $key => $attribute) {
            if ($key !== 'updated_by' && $key !== 'updated_at' && $key !== 'content') {
                $this->$key = $entry->augmentedValue($key)->value();
            } else {
                $this->$key = $entry->augmentedValue($key);
            }
        }

        $this->slug      = $entry->slug();
        $this->available = $entry->published();

        return $this;
    }

    public function available(): bool
    {
        return $this->entry->published();
    }

    /**
     * A Product has taxes
     */
    public function tax()
    {
        return Tax::firstWhere('slug', $this->tax_id);
    }

    /**
     * A Product has categories
     */
    public function categories()
    {
        return; // TODO: Add categories relation
    }

    /**
     * A Product has a shipping relation
     */
    public function shippingProfile()
    {
        return ShippingProfile::firstWhere('slug', $this->shipping_profile_slug);
    }

    /**
     * A Product has variants
     */
    public function variants()
    {
        return collect(); // TODO: return variants
        return $this->hasMany(Variant::class);
    }
//
//    /**
//     * The product will return the belonging variant. Null will be returned,
//     * in case a variant can't be connected to the given slug
//     */
//    public function getVariant(String $variantTitle)
//    {
//        return $this->variants->where('original_title', $variantTitle)->first();
//    }
//
//    /**
//     * Will check if a variant with the given title does exist,
//     * related to this product.
//     */
//    public function variantExists($title): bool
//    {
//        return $this->variants->contains('original_title', $title);
//    }

    /**
     * Do variants exsist?
     */
    public function hasVariants()
    {
        // TODO: Rewrite
        return false;
        return $this->variants->count() !== 0;
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
        $tax   = str_replace(',', '.', $this->tax->percentage);
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

    /**
     * Adding some product information dynamically
     */
    private function extend(EntryCollection $entry): Collection
    {
        return $entry->map(function ($entry) {
            $entry->fluentlyGetOrSet('show_url')->args([$this->showUrl($entry->slug())]);
            $entry->fluentlyGetOrSet('slug')->args([$entry->slug()]);
            return $entry;
        });
    }

    public function __get(string $property)
    {
        if (! method_exists($this, $property)) {
           return;
        }

        return call_user_func([$this, $property]);
    }
}
