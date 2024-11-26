<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientLastName
{
    /**
     * @param string $lastName
     */
    public function __construct(private string $lastName)
    {
        //TODO: реализовать проверку фамилии
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
