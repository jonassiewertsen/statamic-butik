<?php

namespace Jonassiewertsen\StatamicButik\Repositories;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Contracts\ProductRepository as ProductRepositoryContract;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;

class ProductRepository implements ProductRepositoryContract
{
    public function all(): Collection
    {
        return collect($this->query()->all());
    }

    public function find(string $id): ?\Statamic\Entries\Entry
    {
        return Entry::find($id);
    }

    public function findBySlug(string $slug): ?\Statamic\Entries\Entry
    {
        return Entry::query()
            ->where('site', Site::current()->handle())
            ->where('collection', $this->collection())
            ->where('slug', $slug)
            ->first();
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
