<?php

namespace Jonassiewertsen\Butik\Support;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Contracts\ButikEntryContract;
use Jonassiewertsen\Butik\Exceptions\ButikProductException;
use Statamic\Contracts\Entries\Entry as EntryContract;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Support\Str;

abstract class ButikEntry implements ButikEntryContract
{
    public string $id;
    public string $title;
    public string $slug;
    public array $data;
    public bool $published;
    public ?EntryContract $entry;

    public function all(): Collection
    {
        return collect($this->query()->all());
    }

    public function find(string $id): ?self
    {
        if (! $this->entry = Entry::find($id)) {
            return null;
        }

        $this->defineAttributes();

        return $this;
    }

    public function findBySlug(string $slug): ?self
    {
        $this->entry = Entry::query()
            ->where('site', Site::current()->handle())
            ->where('collection', $this->collection())
            ->where('slug', $slug)
            ->first();

        if (! $this->entry) {
            return null;
        }

        $this->defineAttributes();

        return $this;
    }

    public function exists(string $slug): bool
    {
        return (bool) Entry::find($slug);
    }

    public function query()
    {
        return Entry::whereCollection($this->collection());
    }

    public function fresh(): self
    {
        return $this->find($this->id);
    }

    public function update(array $data): bool
    {
        $data = array_merge($this->data, $data);

        return $this->entry->data($data)->save();
    }

    public function delete(string $id): bool
    {
        if (! $product = $this->find($id)) {
            throw ButikProductException::cantDeleteNonExistingProduct($id);
        }

        return $this->find($id)->entry->delete();
    }

    /*
     * A little magic for butik entries.
     */
    public function __get($name)
    {
        /*
         * You can call methods as attributes, to keep a nice syntax.
         * Feel free to fx call `->stock()` or `->stock`
         */
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        /*
         * Camel- or snake-case? What about both? That would be nice, right?
         * `->stock_unlimited` and `stockUnlimited` do work the same.
         */
        if (method_exists($this, $camel = Str::camel($name))) {
            return $this->$camel();
        }
    }

    /*
     * For better acces, we will set some attribtues as default.
     */
    protected function defineAttributes(): void
    {
        $this->id = $this->entry->id();
        $this->title = $this->entry->get('title');
        $this->slug = $this->entry->slug();
        $this->data = $this->entry->data()->toAugmentedArray();
        $this->published = $this->entry->published();
    }
}
