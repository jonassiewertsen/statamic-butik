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

    public function of(mixed $number): self
    {
        $this->number = $this->convertToNumber($number);

        return $this;
    }

    public function add(mixed $number): self
    {
        $this->number += $this->convertToNumber($number);

        return $this;
    }

    public function subtract(mixed $number): self
    {
        $this->number -= $this->convertToNumber($number);

        return $this;
    }

    public function multiply(float | int $by): self
    {
        $this->number *= $by;

        return $this;
    }

    public function divide(float | int $by): self
    {
        $this->number = (int) round($this->number / $by);

        return $this;
    }

    public function get(): string
    {
        $amount = floatval($this->number) / $this->multiplicator;

        return (string) number_format($amount, 2, $this->delimiter, ',');
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

    private function fromStringToNumber($number): float | int
    {
        $number = str_replace(',', '.', $number);

        return (int) $this->multiplicator * (float) $number;
    }
}
