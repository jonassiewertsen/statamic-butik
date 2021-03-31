<?php

namespace Jonassiewertsen\Butik\Contracts;

interface ProductRepository
{
    public function stock(): int;

    public function tax(): object;

    public function taxType(): string;

    public function price(): object;

    public function stockUnlimited(): bool;
}
