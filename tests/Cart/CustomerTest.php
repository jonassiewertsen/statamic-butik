<?php

namespace Tests\Cart;

use Jonassiewertsen\Butik\Cart\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    protected array $jonDoe;

    public function setUp(): void
    {
        parent::setUp();

        $this->jonDoe = [
            'firstname'   => 'Jon',
            'surname'     => 'Doe',
            'email'       => 'Jon@Doe.com',
            'address1'    => 'Test Street',
            'address2'    => 'Test Addition',
            'city'        => 'Flensburg',
            'stateRegion' => 'SH',
            'zip'         => '23454',
            'phone'       => '1234567',
            'country'     => 'Germania',
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

        $customer->firstname($this->jonDoe['firstname']);
        $customer->surname($this->jonDoe['surname']);
        $customer->email($this->jonDoe['email']);
        $customer->address1($this->jonDoe['address1']);
        $customer->address2($this->jonDoe['address2']);
        $customer->city($this->jonDoe['city']);
        $customer->stateRegion($this->jonDoe['stateRegion']);
        $customer->zip($this->jonDoe['zip']);
        $customer->phone($this->jonDoe['phone']);
        $customer->country($this->jonDoe['country']);

        $this->assertEquals($customer->firstname, $this->jonDoe['firstname']);
        $this->assertEquals($customer->surname, $this->jonDoe['surname']);
        $this->assertEquals($customer->email, $this->jonDoe['email']);
        $this->assertEquals($customer->address1, $this->jonDoe['address1']);
        $this->assertEquals($customer->address2, $this->jonDoe['address2']);
        $this->assertEquals($customer->city, $this->jonDoe['city']);
        $this->assertEquals($customer->stateRegion, $this->jonDoe['stateRegion']);
        $this->assertEquals($customer->zip, $this->jonDoe['zip']);
        $this->assertEquals($customer->phone, $this->jonDoe['phone']);
        $this->assertEquals($customer->country, $this->jonDoe['country']);
    }

    /** @test */
    public function a_full_name_can_be_returned()
    {
        $customer = new Customer($this->jonDoe);

        $this->assertEquals(
            $customer->name(),
            $customer->firstname.' '.$customer->surname
        );
    }
}
