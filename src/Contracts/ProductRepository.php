<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;

interface ProductRepository
{
    public function all(): Collection;

    public function find(string $id): ?\Statamic\Entries\Entry;

    public function findBySlug(string $slug): ?\Statamic\Entries\Entry;

    public function toArray(): array;

    public function query(); // Typehint ?

    public function save($entry);

    public function delete($entry);

    public function collection(): string;
}
