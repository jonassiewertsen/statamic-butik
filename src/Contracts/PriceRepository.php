<?php

namespace Jonassiewertsen\Butik\Contracts;

interface PriceRepository
{
    public function __construct(string $delimiter, string $thousands_separator);

    public function of(mixed $amount): self;

    public function add(mixed $amount): self;

    public function subtract(mixed $amount): self;

    public function multiply(float|int $by): self;

    public function divide(float|int $by): self;

    public function divide($by): self;

    public function delimiter(string $delimiter): self;

    public function thousands(string $thousands): self;

    public function get(): string;

    public function cents(): int;
}
