<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;

interface ProductRepository
{
    public function all(): Collection;

    public function find(string $id): ?self;

    public function findBySlug(string $slug): ?self;

    public function exists(string $slug): bool;

    public function toArray(): array;

    public function query(); // Typehint ?

    public function save($entry);

    public function delete($entry);

    public function collection(): string;

    public function stock(): int;

    public function tax(): object;

    public function price(): object;

    public function stockUnlimited(): int;
}
