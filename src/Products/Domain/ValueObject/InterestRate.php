<?php

namespace App\Products\Domain\ValueObject;

class InterestRate
{
    /**
     * @var float
     */
    private float $rate;

    /**
     * @param float $rate
     */
    public function __construct(float $rate)
    {
        if ($rate < 0 || $rate > 100) {
            throw new \InvalidArgumentException('Interest rate must be between 0 and 100.');
        }

        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->rate;
    }
}
