<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Statamic\Entries\EntryCollection;
use Statamic\Facades\Entry;
use Statamic\Support\Str;

class Product
{
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

        if ($entry === null) {
            return null;
        }

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
        return DB::table('butik_category_product')
                ->where(['product_slug' => $this->slug])
                ->join('butik_categories', 'butik_category_product.category_slug', '=', 'butik_categories.slug')
                ->get();
    }

    /**
     * A Product has a shipping relation
     */
    public function shipping_profile()
    {
        return ShippingProfile::firstWhere('slug', $this->shipping_profile_slug);
    }

    /**
     * A Product has variants
     */
    public function variants()
    {
        return Variant::where('product_slug', $this->slug)->get();
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
    public function variantExists(string $title): ?bool
    {
        return $this->variants->contains('original_title', $title);
    }

    /**
     * Do variants exsist?
     */
    public function hasVariants(): bool
    {
        return $this->variants->count() !== 0;
    }

    /**
     * Will return the shipping price
     */
    public function tax_percentage()
    {
        return $this->tax->percentage;
    }

    public function tax_amount()
    {
        $tax   = str_replace(',', '.', $this->tax->percentage);
        $price = (float) $this->price;
        $total = $price * ($tax / (100 + $tax));

        return round($total, 2);
    }

    /**
     * Is the product still in stock?
     */
    public function sold_out()
    {
        if ($this->stock_unlimited) {
            return false;
        }
        return $this->stock == 0;
    }

    /**
     * Return the price with currency appended
     */
    public function currency()
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

    public function show_url()
    {
        $route = config('butik.route_shop-prefix') . '/' . $this->slug;
        return Str::of($route)->start('/');
    }

    public function __get(string $property)
    {
        if (! method_exists($this, $property)) {
           return;
        }

        return call_user_func([$this, $property]);
    }
}
