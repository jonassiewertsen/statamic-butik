<?php

namespace Jonassiewertsen\StatamicButik\Repositories;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Contracts\ProductRepository as ProductRepositoryContract;
use Statamic\Facades\Entry;

class ProductRepository implements ProductRepositoryContract
{
    public function all(): Collection
    {
        return collect($this->query()->all());
    }

    public function find($id): self
    {
        //
    }

    public function findBySlug(string $slug): self
    {
        //
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
