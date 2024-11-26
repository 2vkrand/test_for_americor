<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientFirstName
{
    /**
     * @param string $firstName
     */
    public function __construct(private string $firstName)
    {
        //TODO: реализовать проверку имени
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
