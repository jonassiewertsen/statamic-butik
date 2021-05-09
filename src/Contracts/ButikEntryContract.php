<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;
use Statamic\Contracts\Entries\QueryBuilder;

interface ButikEntryContract
{
    public function all(): Collection;

    public function find(string $id): self | null;

    public function findBySlug(string $slug): self | null;

    public function exists(string $slug): bool;

    public function query(): QueryBuilder;

    public function update(array $data);

    public function delete(string $id);

    public function collection(): string;

    public function toArray(): array;
}
