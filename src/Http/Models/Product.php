<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product as ProductFacade;
use Statamic\Entries\EntryCollection;
use Statamic\Facades\Entry;
use Statamic\Stache\Query\EntryQueryBuilder;
use Statamic\Support\Str;

class Product
{
    use MoneyTrait;

    protected const COLLECTION_NAME = 'products';
    public string            $slug;
    public bool              $available;
    public EntryQueryBuilder $entries;

    public function all()
    {
        return $this->extend(
            Entry::query()
                ->where('collection', self::COLLECTION_NAME)
                ->where('published', true)
                ->get()
        );
    }

    public function fromCategory(Category $category)
    {
        $slugs = $category->products->pluck('slug')->toArray();

        $products = $this->all()->filter(function ($product) use ($slugs) {
            return in_array($product->slug(), $slugs);
        });

        return $this->extend($products);
    }

    public function find(string $slug)
    {
        $entry = Entry::findBySlug($slug, self::COLLECTION_NAME);

        if ($entry === null) {
            return null;
        }

        $product = new Product();

        foreach ($entry->values() as $key => $attribute) {
            if ($key !== 'updated_by' && $key !== 'updated_at' && $key !== 'content' && is_int($key)) {
                $product->$key = $entry->augmentedValue($key)->value();
            } else {
                $product->$key = $entry->augmentedValue($key);
            }
        }

        $product->price           = str_replace('.', config('butik.currency_delimiter'), $product->price);
        $product->slug            = $entry->slug();
        $product->id              = $entry->id();
        $product->title           = $entry->get('title');
        $product->stock           = (int)$entry->get('stock');
        $product->stock_unlimited = (bool)$entry->get('stock_unlimited');
        $product->available       = $entry->published();
        $product->show_url        = $product->showUrl($product->slug);

        return $product;
    }

    public function where(string $key, string $value)
    {
        return Entry::query()
            ->where('collection', self::COLLECTION_NAME)
            ->where($key, $value);
    }

    public function get(): Collection
    {
        $entries = collect();

        $this->entries->get()->each(function ($entry) use ($entries) {
            $entries->push(ProductFacade::find($entry->slug()));
        });

        return $this->extend($entries);
    }

    public function exists(string $slug): bool
    {
        return Entry::findBySlug($slug, self::COLLECTION_NAME) !== null;
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
    public function shippingProfile()
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
     * Will return the shipping price
     */
    public function taxPercentage()
    {
        return $this->tax->percentage;
    }

    public function taxAmount()
    {
        $tax   = str_replace(',', '.', $this->tax->percentage);
        $price = (float)$this->price;
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
     * Return the price with currency appended
     */
    public function currency()
    {
        return config('butik.currency_symbol');
    }

    public function showUrl($slug): string
    {
        $route = config('butik.route_shop-prefix') . '/' . $slug;
        return (string)Str::of($route)->start('/');
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

        return;
    }

    /**
     * Adding some product information dynamically
     */
    public function extend(EntryCollection $entry): Collection
    {
        return $entry->map(function ($entry) {
            $entry->fluentlyGetOrSet('show_url')->args([$this->showUrl($entry->slug())]);
            $entry->fluentlyGetOrSet('slug')->args([$entry->slug()]);
            $entry->fluentlyGetOrSet('price')->args([str_replace('.', config('butik.currency_delimiter'), $entry->get('price'))]);
            return $entry;
        });
    }
}
