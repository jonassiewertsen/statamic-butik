<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product as ProductFacade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Statamic\Entries\Entry as StatamicEntry;
use Statamic\Entries\EntryCollection;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Support\Str;

class Product
{
    use MoneyTrait;

    protected const COLLECTION_NAME = 'products';
    public string            $slug;
    public bool              $available;
    public Collection        $entries;

    public function all()
    {
        $entries = Entry::query()
            ->where('collection', self::COLLECTION_NAME)
            ->where('site', Site::current()->handle())
            ->where('published', true)
            ->get();

        return $this->transform($entries);
    }

    public function fromCategory(Category $category)
    {
        $productIds = $category->products->pluck('id')->toArray();

        return $this->all()->filter(function ($product) use ($productIds) {
            return in_array($product->id, $productIds);
        });
    }

    public function find(string $slug): ?Product
    {
        $entry = Entry::query()
            ->where('slug', $slug)
            ->where('collection', self::COLLECTION_NAME)
            ->where('site', Site::current()->handle())
            ->first();

        if ($entry === null) {
            return null;
        }

        return $this->extend($entry);
    }

    public function where(string $key, string $value)
    {
        return Entry::query()
            ->where('site', Site::current()->handle())
            ->where('collection', self::COLLECTION_NAME)
            ->where($key, $value);
    }

    public function get(): Collection
    {
        $entries = collect();

        $this->entries->get()->each(function ($entry) use ($entries) {
            $entries->push(ProductFacade::find($entry->slug()));
        });

        return $this->transform($entries);
    }

    public function firstByName()
    {
        $entries = Entry::query()
            ->where('published', true)
            ->where('site', Site::current()->handle())
            ->where('collection', self::COLLECTION_NAME)
            ->orderBy('title')
            ->limit(config('butik.overview_limit', '6'))
            ->get();

        return $this->transform($entries);
    }

    public function latest()
    {
        $entries = Entry::query()
            ->where('published', true)
            ->where('site', Site::current()->handle())
            ->where('collection', self::COLLECTION_NAME)
            ->orderBy('created_at')
            ->limit(config('butik.overview_limit', '6'))
            ->get();

        return $this->transform($entries);
    }

    public function latestByPrice()
    {
        $entries = Entry::query()
            ->where('published', true)
            ->where('site', Site::current()->handle())
            ->where('collection', self::COLLECTION_NAME)
            ->orderBy('price')
            ->limit(config('butik.overview_limit', '6'))
            ->get();

        return $this->transform($entries);
    }

    public function exists(string $slug): bool
    {
        /**
         * In case it's a variant, we will check if the variant does exist.
         */
        if (Str::contains($slug, '::')) {
            return Variant::exists(Str::of($slug)->explode('::')[1]);
        }

        return (bool) Entry::query()
            ->where('slug', $slug)
            ->where('collection', self::COLLECTION_NAME)
            ->where('site', Site::current()->handle())
            ->count();
    }

    public function available(): bool
    {
        return $this->entry->published();
    }

    /**
     * A Product has taxes.
     */
    public function tax()
    {
        return Tax::firstWhere('slug', $this->tax_id);
    }

    /**
     * A Product has categories.
     */
    public function categories()
    {
        return DB::table('butik_category_product')
            ->where(['product_slug' => $this->slug])
            ->join('butik_categories', 'butik_category_product.category_slug', '=', 'butik_categories.slug')
            ->get();
    }

    /**
     * A Product has a shipping relation.
     */
    public function shippingProfile()
    {
        return ShippingProfile::firstWhere('slug', $this->shipping_profile_slug);
    }

    /**
     * A Product has variants.
     */
    public function variants()
    {
        return Variant::where('product_slug', $this->slug)->get();
    }

    /**
     * The product will return the belonging variant. Null will be returned,
     * in case a variant can't be connected to the given slug.
     */
    public function getVariant(string $variantTitle)
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
     * Will return the shipping price.
     */
    public function taxPercentage()
    {
        return $this->tax->percentage;
    }

    public function taxAmount()
    {
        $tax = str_replace(',', '.', $this->tax->percentage);
        $price = (float) $this->price;
        $total = $price * ($tax / (100 + $tax));

        return $this->humanPrice($total);
    }

    /**
     * Is the product still in stock?
     */
    public function soldOut()
    {
        if ($this->stock_unlimited) {
            return false;
        }

        return $this->stock == 0;
    }

    /**
     * Return the price with currency appended.
     */
    public function currency()
    {
        return config('butik.currency_symbol');
    }

    public function showUrl($slug): string
    {
        if(! config('butik.product_route_active')) {
            return '';
         }

        return route('butik.shop.product', ['product' => $slug], false);
    }

    public function __get(string $property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        /**
         * You can call methods as well in snake syntax (show_url).
         */
        if (method_exists($this, Str::camel($property))) {
            return call_user_func([$this, Str::camel($property)]);
        }

        return null;
    }

    private function transform(EntryCollection $entries): Collection
    {
        return $entries->transform(function ($entry) {
            return $this->extend($entry);
        });
    }

    private function extend(StatamicEntry $entry): Product
    {
        $product = new Product();

        foreach ($entry->values() as $key => $attribute) {
            if ($key !== 'updated_by' && $key !== 'updated_at' && $key !== 'content' && is_int($key)) {
                $product->$key = $entry->augmentedValue($key)->value();
            } else {
                $product->$key = $entry->augmentedValue($key);
            }
        }

        $product->price = str_replace('.', config('butik.currency_delimiter'), $product->price);
        $product->slug = $entry->slug();
        $product->id = $entry->id();
        $product->title = $entry->value('title');
        $product->stock = (int) $entry->value('stock');
        $product->stock_unlimited = (bool) $entry->value('stock_unlimited');
        $product->available = (bool) $entry->published();
        $product->show_url = $product->showUrl($product->slug);

        return $product;
    }
}
