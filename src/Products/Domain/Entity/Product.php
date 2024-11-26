<?php

namespace App\Products\Domain\Entity;

use App\Products\Domain\ValueObject\ProductName;
use App\Products\Domain\ValueObject\InterestRate;
use App\Products\Domain\ValueObject\LoanTerm;
use App\Products\Domain\ValueObject\LoanAmount;
use App\Shared\Domain\ValueObject\Ulid;

class Product
{
    /**
     * @var Ulid
     */
    private readonly Ulid $ulid;

    /**
     * @param Ulid $ulid
     * @param ProductName $name
     * @param InterestRate $interestRate
     * @param LoanTerm $loanTerm
     * @param LoanAmount $loanAmount
     */
    public function __construct(
        Ulid $ulid,
        private ProductName $name,
        private InterestRate $interestRate,
        private LoanTerm $loanTerm,
        private LoanAmount $loanAmount
    ) {
        $this->ulid = $ulid;
    }

    /**
     * @return string
     */
    public function getUlid(): string
    {
        return $this->ulid->getValue();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name->getValue();
    }

    /**
     * @param ProductName $name
     * @return void
     */
    public function changeName(ProductName $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getInterestRate(): float
    {
        return $this->interestRate->getValue();
    }

    /**
     * @param InterestRate $interestRate
     * @return void
     */
    public function changeInterestRate(InterestRate $interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return int
     */
    public function getLoanTerm(): int
    {
        return $this->loanTerm->getValue();
    }

    /**
     * @param LoanTerm $loanTerm
     * @return void
     */
    public function changeLoanTerm(LoanTerm $loanTerm): void
    {
        $this->loanTerm = $loanTerm;
    }

    /**
     * @return float
     */
    public function getLoanAmount(): float
    {
        return $this->loanAmount->getValue();
    }

    /**
     * @param LoanAmount $amount
     * @return void
     */
    public function changeAmount(LoanAmount $amount): void
    {
        $this->loanAmount = $amount;
    }
}
