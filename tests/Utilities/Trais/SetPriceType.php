<?php

namespace Tests\Utilities\Trais;

trait SetPriceType
{
    protected function setGrossPriceAsDefault(): void
    {
        config()->set('butik.price', 'gross');
    }

    protected function setNetPriceAsDefault(): void
    {
        config()->set('butik.price', 'net');
    }
}
