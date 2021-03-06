<?php

namespace Jonassiewertsen\StatamicButik\Support;

use Jonassiewertsen\StatamicButik\Contracts\NumberRepository;

class Number implements NumberRepository
{
    public int $multiplicator;
    public string $delimiter = '.';
    public int $number = 0;

    public function __construct()
    {
        $this->multiplicator = pow(10, 10);
    }

    public function of($number): self
    {
        $this->number = $this->convertToNumber($number);

        return $this;
    }

    public function add($number): self
    {
        $this->number += $this->convertToNumber($number);

        return $this;
    }

    public function subtract($number): self
    {
        $this->number -= $this->convertToNumber($number);

        return $this;
    }

    public function multiply($by): self
    {
        $this->number *= $by;

        return $this;
    }

    public function decimal(): float
    {
        $number = $this->number / $this->multiplicator;

        return number_format($number, 2, $this->delimiter, ',');
    }

    public function int(): int
    {
        return (int) $this->number / $this->multiplicator;
    }

    protected function convertToNumber($number): int
    {
        switch (gettype($number)) {
            case 'integer':
                return $this->multiplicator * $number;
            case 'double':
                return (int) $this->multiplicator * $number;
            case 'string':
                return $this->fromStringToNumber($number);
            case 'NULL':
                return 0;
        }
    }

    private function fromStringToNumber($number)
    {
        $number = str_replace(',', '.', $number);

        return (int) $this->multiplicator * (float) $number;
    }
}