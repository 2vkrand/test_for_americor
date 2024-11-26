<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientCreditInfoSSN
{
    /**
     * @param string $ssn
     */
    public function __construct(private string $ssn)
    {
        //TODO: реализовать проверку ssn
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->ssn;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
