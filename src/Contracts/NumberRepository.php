<?php

namespace Jonassiewertsen\Butik\Contracts;

interface NumberRepository
{
    public function of($number): self;

    public function add($number): self;

    public function subtract($number): self;

    public function multiply($by): self;

    public function divide($by): self;

    public function decimal(): float;

    public function int(): int;
}
