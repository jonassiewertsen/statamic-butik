<?php

namespace Jonassiewertsen\Butik\Contracts;

interface PriceRepository
{
    public function __construct(string $delimiter, string $thousands_separator);

    public function of($amount): self;

    public function add($amount): self;

    public function subtract($amount): self;

    public function multiply($by): self;

    public function divide($by): self;

    public function delimiter(string $delimiter): self;

    public function thousands(string $thousands): self;

    public function get(): string;

    public function cents(): int;
}
