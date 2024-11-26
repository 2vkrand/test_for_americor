<?php

namespace App\Products\Domain\ValueObject;

class ProductName
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Product name cannot be empty.');
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
    }
}
