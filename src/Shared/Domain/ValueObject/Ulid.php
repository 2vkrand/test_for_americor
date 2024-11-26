<?php

namespace App\Shared\Domain\ValueObject;

readonly class Ulid
{
    /**
     * @param string $uuid
     */
    public function __construct(private string $uuid)
    {
        //TODO: реализовать валидацию ulid
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
