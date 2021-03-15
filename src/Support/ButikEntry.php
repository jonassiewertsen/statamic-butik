<?php

namespace Jonassiewertsen\Butik\Support;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Statamic\Support\Str;

abstract class ButikEntry implements ProductRepository
{
    public string $id;
    public string $title;
    public string $slug;
    public array $data;
    public bool $published;
    public ?\Statamic\Contracts\Entries\Entry $entry;

    abstract public function all(): Collection;

    abstract public function find(string $id): ?self;

    abstract public function findBySlug(string $slug): ?self;

    abstract public function toArray(): array;

    abstract public function query();

    abstract public function update(array $data);

    abstract public function delete(string $id);

    abstract public function collection(): string;

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (method_exists($this, $camel = Str::camel($name))) {
            return $this->$camel();
        }
    }

    protected function defineAttributes(): void
    {
        $this->id = $this->entry->id();
        $this->title = $this->entry->get('title');
        $this->slug = $this->entry->slug();
        $this->data = $this->entry->data()->toAugmentedArray();
        $this->published = $this->entry->published();
    }
}
