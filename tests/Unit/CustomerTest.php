<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CustomerTest extends TestCase
{
    protected Customer $customer;
    protected array    $jonDoe;

    public function setUp(): void {
        parent::setUp();
        $this->customer = new Customer();

        $this->jonDoe = [
            'name' => 'Jon Doe',
            'mail' => 'Jon@Doe.com',
            'address1' => 'Test Street',
            'address2' => 'Test Addition',
            'city' => 'Flensburg',
            'stateRegion' => 'SH',
            'zip' => '23454',
            'phone' => '1234567',
            'country' => 'Germania',
        ];
    }

    /** @test */
    public function a_customer_can_be_created()
    {
        $this->customer->create($this->jonDoe);

        $this->assertEquals($this->jonDoe, (array) $this->customer);
    }

    /** @test */
    public function the_customer_setters_can_be_used(){
        $this->customer->name($this->jonDoe['name']);
        $this->customer->mail($this->jonDoe['mail']);
        $this->customer->address1($this->jonDoe['address1']);
        $this->customer->address2($this->jonDoe['address2']);
        $this->customer->city($this->jonDoe['city']);
        $this->customer->stateRegion($this->jonDoe['stateRegion']);
        $this->customer->zip($this->jonDoe['zip']);
        $this->customer->phone($this->jonDoe['phone']);
        $this->customer->country($this->jonDoe['country']);

        $this->assertEquals($this->customer->name, $this->jonDoe['name']);
        $this->assertEquals($this->customer->mail, $this->jonDoe['mail']);
        $this->assertEquals($this->customer->address1, $this->jonDoe['address1']);
        $this->assertEquals($this->customer->address2, $this->jonDoe['address2']);
        $this->assertEquals($this->customer->city, $this->jonDoe['city']);
        $this->assertEquals($this->customer->stateRegion, $this->jonDoe['stateRegion']);
        $this->assertEquals($this->customer->zip, $this->jonDoe['zip']);
        $this->assertEquals($this->customer->phone, $this->jonDoe['phone']);
        $this->assertEquals($this->customer->country, $this->jonDoe['country']);
    }
}
