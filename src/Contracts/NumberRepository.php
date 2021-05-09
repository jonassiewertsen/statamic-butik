<?php

namespace Jonassiewertsen\Butik\Contracts;

interface NumberRepository
{
    public function of(mixed $number): self;

    public function add(mixed $number): self;

    public function subtract(mixed $number): self;

    public function multiply(float | int $by): self;

    public function divide(float | int $by): self;

    public function get(): string;

    public function decimal(): float;

    public function int(): int;
}
