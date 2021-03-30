<?php

namespace Jonassiewertsen\Butik\Product;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Exceptions\ButikProductException;
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

    public function collection(): string
    {
        return 'products'; // TODO: Pull from config
    }

    public function stock(): int
    {
        return (int) $this->data['stock'];
    }

    public function stockUnlimited(): bool
    {
        return $this->data['stock_unlimited'];
    }

    public function tax(): object
    {
        return (object) $this->entry->augmentedValue('tax_id')->value();
    }

    public function price(): object
    {
        return (object) $this->entry->augmentedValue('price')->value();
    }

    public function toArray(): array
    {
        //
    }
}
