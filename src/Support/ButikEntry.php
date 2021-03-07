<?php

namespace Jonassiewertsen\Butik\Support;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Statamic\Contracts\Entries\Entry;

abstract class ButikEntry implements ProductRepository
{
    public string $id;
    public string $title;
    public string $slug;
    public array $data;
    public bool $published;

    abstract public function all(): Collection;

    abstract public function find(string $id): ?self;

    abstract public function findBySlug(string $slug): ?self;

    abstract public function toArray(): array;

    abstract public function query();

    abstract public function save($entry);

    abstract public function delete($entry);

    abstract public function collection(): string;

    protected function defineAttributes(Entry $product): void
    {
        $this->id = $product->id();
        $this->title = $product->get('title');
        $this->slug = $product->slug();
        $this->data = $product->data()->toArray();
        $this->published = $product->published();
    }
}
