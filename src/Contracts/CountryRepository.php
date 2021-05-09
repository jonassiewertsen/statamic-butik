<?php

namespace Jonassiewertsen\Butik\Contracts;

interface CountryRepository
{
    public function name(?string $isoCode = null): string | null;

    public function iso(): string;

    public function set(string $isoCode): bool;

    public function exists(string $isoCode): bool;

    public function defaultName(): string;

    public function defaultIso(): string;
}
