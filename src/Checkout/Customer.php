<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

class Customer
{
    public ?string $firstname;
    public ?string $surname;
    public ?string $mail;
    public ?string $address1;
    public ?string $address2;
    public ?string $city;
    public ?string $stateRegion;
    public ?string $zip;
    public ?string $phone;
    public ?string $country;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $attribute) {
            $this->$key = $attribute;
        }
    }

    public function name(): string
    {
        return $this->firstname.' '.$this->surname;
    }

    public function empty(): self
    {
        $fields = ['firstname', 'surname', 'mail', 'phone', 'address1', 'address2', 'city', 'stateRegion', 'zip', 'phone', 'country'];

        foreach ($fields as $field) {
            $this->$field = '';
        }

        return $this;
    }

    public function firstname($value): self
    {
        $this->firstname = $value;

        return $this;
    }

    public function surname($value): self
    {
        $this->surname = $value;

        return $this;
    }

    public function mail($value): self
    {
        $this->mail = $value;

        return $this;
    }

    public function address1($value): self
    {
        $this->address1 = $value;

        return $this;
    }

    public function address2($value): self
    {
        $this->address2 = $value;

        return $this;
    }

    public function city($value): self
    {
        $this->city = $value;

        return $this;
    }

    public function stateRegion($value): self
    {
        $this->stateRegion = $value;

        return $this;
    }

    public function zip($value): self
    {
        $this->zip = $value;

        return $this;
    }

    public function phone($value): self
    {
        $this->phone = $value;

        return $this;
    }

    public function country($value): self
    {
        $this->country = $value;

        return $this;
    }
}
