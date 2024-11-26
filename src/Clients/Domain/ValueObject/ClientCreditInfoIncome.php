<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientCreditInfoIncome
{
    /**
     * @param float $income
     */
    public function __construct(private float $income)
    {
        if ($income < 0) {
            throw new \InvalidArgumentException('Доход не может быть меньше нуля');
        }
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->income;
    }
}
