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

        return $this;
    }

    public function exists(string $slug): bool
    {
        return (bool) Entry::find($slug);
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

    public function stock(): int
    {
        return 0;
    }

    public function stockUnlimited(): int
    {
        return 0;
    }

    public function tax(): object
    {
        // Refactor to use tax instead of tax_id
        return (object) $this->entry->augmentedValue('tax_id')->value();
    }

    public function price(): object
    {
        return (object) $this->entry->augmentedValue('price')->value();
    }
}
