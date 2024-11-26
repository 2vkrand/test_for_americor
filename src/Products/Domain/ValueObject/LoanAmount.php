<?php

namespace App\Products\Domain\ValueObject;

class LoanAmount
{
    /**
     * @var float
     */
    private float $amount;

    /**
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('LoanAmount must be greater than 0.');
        }

        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->amount;
    }
}
