<?php

namespace Jonassiewertsen\StatamicButik\Price;

use Jonassiewertsen\StatamicButik\Contracts\PriceRepository;

class Price implements PriceRepository
{
    public string $delimiter;
    public string $thousands_separator;
    public int $amount = 0;

    public function __construct(string $delimiter, string $thousands_separator)
    {
        $this->delimiter = $delimiter;
        $this->thousands_separator = $thousands_separator;
    }

    public function of($amount): self
    {
        switch (gettype($amount)) {
            case 'integer':
                $this->amount = $amount;
                break;
            case 'string':
                $this->amount = $this->fromStringToInt($amount);
                break;
        }

        return $this;
    }

    public function getAmount(): string
    {
        $amount = floatval($this->amount) / 100;

        return number_format($amount, 2, $this->delimiter, $this->thousands_separator);
    }

    public function getCents(): int
    {
        return $this->amount;
    }

    protected function fromStringToInt(string $amount): int
    {
        // Any string will change the delimiter to a dot as delimiter.
        $amount = str_replace($this->delimiter, '.', $amount);

        // As any string uses a dot, we can convert it into a float.
        $amount = (float) $amount * 100;

        return (int) $amount;
    }
}
