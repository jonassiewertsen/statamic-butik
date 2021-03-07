<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;

interface ProductRepository
{
    public function all(): Collection;

    public function find(string $id): ?self;

    public function findBySlug(string $slug): ?self;

    public function toArray(): array;

    public function query(); // Typehint ?

    public function save($entry);

    public function delete($entry);

    public function collection(): string;
}
