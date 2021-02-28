<?php

namespace Jonassiewertsen\StatamicButik\Contracts;

interface PriceRepository
{
    public function __construct(string $delimiter, string $thousands_separator);

    public function of($amount): self;

    public function getAmount(): string;

    public function getCents(): int;
}
