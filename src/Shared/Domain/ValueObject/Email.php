<?php

namespace App\Shared\Domain\ValueObject;

readonly class Email
{
    /**
     * @param string $email
     */
    public function __construct(private string $email)
    {
        //TODO: реалиовать проверку электронной почты.
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
