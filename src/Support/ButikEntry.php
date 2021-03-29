<?php

namespace Jonassiewertsen\Butik\Support;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Statamic\Contracts\Entries\Entry;
use Statamic\Support\Str;

abstract class ButikEntry implements ProductRepository
{
    public string $id;
    public string $title;
    public string $slug;
    public array $data;
    public bool $published;
    public ?Entry $entry;

    abstract public function all(): Collection;

    abstract public function find(string $id): ?self;

    abstract public function findBySlug(string $slug): ?self;

    abstract public function exists(string $slug): bool;

    abstract public function query();

    abstract public function update(array $data): bool;

    abstract public function delete(string $id): bool;

    abstract public function collection(): string;

    abstract public function toArray(): array;

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
