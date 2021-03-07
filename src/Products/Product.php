<?php

namespace Jonassiewertsen\Butik\Products;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Support\ButikEntry;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;

class Product extends ButikEntry
{
    public function all(): Collection
    {
        return collect($this->query()->all());
    }

    public function find(string $id): ?self
    {
        if (! $product = Entry::find($id)) {
            return null;
        }

        $this->defineAttributes($product);

        return $this;
    }

    public function findBySlug(string $slug): ?self
    {
        $product = Entry::query()
            ->where('site', Site::current()->handle())
            ->where('collection', $this->collection())
            ->where('slug', $slug)
            ->first();

        if (! $product) {
            return null;
        }

        return $this;
    }

    public function toArray(): array
    {
        //
    }

    public function query()
    {
        return Entry::whereCollection($this->collection());
    }

    public function save($entry)
    {
        //
    }

    public function delete($entry)
    {
        //
    }

    public function collection(): string
    {
        return 'products'; // TODO: Pull from config
    }
}
