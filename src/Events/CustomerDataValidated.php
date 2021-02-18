<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Statamic\Auth\User;

class CustomerDataValidated
{
    public Customer $customer;
    public ?User $loggedInUser;

    public function __construct(Customer $customer, ?User $loggedInUser = null)
    {
        $this->customer = $customer;
        $this->loggedInUser = $loggedInUser;
    }
}
