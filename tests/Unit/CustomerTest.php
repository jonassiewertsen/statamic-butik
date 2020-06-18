<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CustomerTest extends TestCase
{
    protected array    $jonDoe;

    public function setUp(): void {
        parent::setUp();

        $this->jonDoe = [
            'name'          => 'Jon Doe',
            'mail'          => 'Jon@Doe.com',
            'address1'      => 'Test Street',
            'address2'      => 'Test Addition',
            'city'          => 'Flensburg',
            'stateRegion'   => 'SH',
            'zip'           => '23454',
            'phone'         => '1234567',
            'country'       => 'Germania',
        ];
    }

    /** @test */
    public function a_customer_can_be_created()
    {
        $customer = new Customer($this->jonDoe);

        $this->assertEquals($this->jonDoe, (array) $customer);
    }

    /** @test */
    public function the_customer_setters_can_be_used()
    {
        $customer = new Customer();

        $customer->name($this->jonDoe['name']);
        $customer->mail($this->jonDoe['mail']);
        $customer->address1($this->jonDoe['address1']);
        $customer->address2($this->jonDoe['address2']);
        $customer->city($this->jonDoe['city']);
        $customer->stateRegion($this->jonDoe['stateRegion']);
        $customer->zip($this->jonDoe['zip']);
        $customer->phone($this->jonDoe['phone']);
        $customer->country($this->jonDoe['country']);

        $this->assertEquals($customer->name, $this->jonDoe['name']);
        $this->assertEquals($customer->mail, $this->jonDoe['mail']);
        $this->assertEquals($customer->address1, $this->jonDoe['address1']);
        $this->assertEquals($customer->address2, $this->jonDoe['address2']);
        $this->assertEquals($customer->city, $this->jonDoe['city']);
        $this->assertEquals($customer->stateRegion, $this->jonDoe['stateRegion']);
        $this->assertEquals($customer->zip, $this->jonDoe['zip']);
        $this->assertEquals($customer->phone, $this->jonDoe['phone']);
        $this->assertEquals($customer->country, $this->jonDoe['country']);
    }
}
