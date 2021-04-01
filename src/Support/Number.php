<?php

namespace Jonassiewertsen\Butik\Support;

use Jonassiewertsen\Butik\Contracts\NumberRepository;

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

    public function divide($by): self
    {
        $this->number /= $by;

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
        return match (gettype($number)) {
            'integer' => $this->multiplicator * $number,
            'double' =>  (int) $this->multiplicator * $number,
            'string' =>  $this->fromStringToNumber($number),
            'default' =>  0,
        };
    }

    private function fromStringToNumber($number)
    {
        $number = str_replace(',', '.', $number);

        return (int) $this->multiplicator * (float) $number;
    }
}
