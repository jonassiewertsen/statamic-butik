<?php

namespace Jonassiewertsen\StatamicButik\Contracts;

interface NumberRepository
{
    public function of($number): self;

    public function add($number): self;

    public function subtract($number): self;

    public function multiply($by): self;

    public function decimal(): float;

    public function int(): int;
}
