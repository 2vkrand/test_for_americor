<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientAge
{
    /**
     * @param int $age
     */
    public function __construct(private int $age)
    {
        if ($age < 16) {
            throw new \InvalidArgumentException('The client age cannot be less than 18');
        }
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->age;
    }
}
