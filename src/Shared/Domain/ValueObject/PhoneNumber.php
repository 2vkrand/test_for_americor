<?php

namespace App\Shared\Domain\ValueObject;

readonly class PhoneNumber
{
    /**
     * @param string $phoneNumber
     */
    public function __construct(private string $phoneNumber)
    {
        //TODO: Реализовать проверку телефонного номера.
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
