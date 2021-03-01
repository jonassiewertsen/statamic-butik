<?php

namespace Jonassiewertsen\StatamicButik\Support;

use Jonassiewertsen\StatamicButik\Contracts\PriceRepository;

class Price implements PriceRepository
{
    public string $delimiter;
    public string $thousands;
    public int $amount = 0;

    public function __construct(string $delimiter, string $thousands_separator)
    {
        $this->delimiter = $delimiter;
        $this->thousands = $thousands_separator;
    }

    public function of($amount): self
    {
        $this->amount = $this->convertToInt($amount);

        return $this;
    }

    public function add($amount): self
    {
        $this->amount += $this->convertToInt($amount);

        return $this;
    }

    public function subtract($amount): self
    {
        $this->amount -= $this->convertToInt($amount);

        return $this;
    }

    public function delimiter(string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function thousands(string $thousands): self
    {
        $this->thousands = $thousands;

        return $this;
    }

    public function get(): string
    {
        $amount = floatval($this->amount) / 100;

        return number_format($amount, 2, $this->delimiter, $this->thousands);
    }

    public function cents(): int
    {
        return $this->amount;
    }

    protected function convertFromStringToInt(string $amount): int
    {
        // Any string will change the delimiter to a dot as delimiter.
        $amount = str_replace($this->delimiter, '.', $amount);

        // As any string uses a dot, we can convert it into a float.
        $amount = (float) $amount * 100;

        return (int) $amount;
    }

    protected function convertToInt($amount): int
    {
        switch (gettype($amount)) {
            case 'integer':
                return $amount;
            case 'string':
                return $this->convertFromStringToInt($amount);
            case 'NULL':
                return 0;
        }
    }
}
