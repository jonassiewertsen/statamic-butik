<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;

interface ButikEntryContract
{
    public function all(): Collection;

    public function find(string $id): ?self;

    public function findBySlug(string $slug): ?self;

    public function exists(string $slug): bool;

    public function query();

    public function update(array $data);

    public function delete(string $id);

    public function collection(): string;

    public function toArray(): array;
}
