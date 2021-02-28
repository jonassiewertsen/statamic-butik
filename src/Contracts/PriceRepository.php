<?php

namespace Jonassiewertsen\StatamicButik\Contracts;

interface PriceRepository
{
    public function __construct(string $delimiter, string $thousands_separator);

    public function of($amount): self;

    public function add($amount): self;

    public function subtract($amount): self;

    public function get(): string;

    public function cents(): int;

}
