<?php

namespace Tests\Fieldsets;

use Statamic\Entries\Entry;
use Tests\TestCase;
use Tests\Utilities\Trais\SetPriceType;

class PriceFieldsetTest extends TestCase
{
    use SetPriceType;

    public Entry $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->makeTax();
        $productId = $this->makeProduct(['price' => '20.00'])->id;
        $this->product = Entry::find($productId);
    }

    /** @test */
    public function it_has_a_raw_value()
    {
        $price = $this->product->augmentedValue('price');

        $this->assertEquals('20.00', $price->value()['raw']);
        $this->setNetPriceAsDefault();
        $this->assertEquals('20.00', $price->value()['raw']);
    }

    /** @test */
    public function it_augments_values_if_the_price_type_is_set_to_gross()
    {
        $price = $this->product->augmentedValue('price');

        $this->assertEquals([
            'gross' => '20,00',
            'net' => '16,81',
            'total' => '20,00',
            'raw' => '20.00',
        ], $price->value());
    }

    /** @test */
    public function it_augments_values_if_the_price_type_is_set_to_net()
    {
        $this->setNetPriceAsDefault();

        $price = $this->product->augmentedValue('price');

        $this->assertEquals([
            'gross' => '23,80',
            'net' => '20,00',
            'total' => '20,00',
            'raw' => '20.00',
        ], $price->value());
    }
}
