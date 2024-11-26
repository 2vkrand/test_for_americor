<?php

namespace App\LoanApplication\Domain\DTO;

use InvalidArgumentException;

class ProductInfoDTO
{
    /**
     * @param string $name
     * @param float $interestRate
     * @param int $loanTerm
     */
    public function __construct(
        readonly private string $name,
        private float $interestRate,
        readonly private int $loanTerm
    ) {
        $this->validate();
    }

    /**
     * @return void
     */
    private function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Product name cannot be empty.');
        }

        if ($this->interestRate < 0 || $this->interestRate > 100) {
            throw new InvalidArgumentException('Interest rate must be between 0 and 100.');
        }

        if ($this->loanTerm <= 0) {
            throw new InvalidArgumentException('Loan term must be a positive integer.');
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     * @return void
     */
    public function setInterestRate(float $interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return int
     */
    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }
}
