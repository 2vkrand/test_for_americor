<?php

namespace App\Clients\Domain\Entity;

use App\Clients\Domain\Service\UlidGeneratorInterface;
use App\Clients\Domain\ValueObject\ClientCreditInfoFICOScore;
use App\Clients\Domain\ValueObject\ClientCreditInfoIncome;
use App\Clients\Domain\ValueObject\ClientCreditInfoSSN;
use App\Shared\Domain\ValueObject\Ulid;

class CreditInfo
{
    /**
     * @var Ulid
     */
    private readonly Ulid $ulid;

    /**
     * @param UlidGeneratorInterface $ulidGenerator
     * @param ClientCreditInfoFICOScore $FICOScore
     * @param ClientCreditInfoSSN $SSN
     * @param ClientCreditInfoIncome $income
     */
    public function __construct(
        UlidGeneratorInterface $ulidGenerator,
        private ClientCreditInfoFICOScore $FICOScore,
        private ClientCreditInfoSSN $SSN,
        private ClientCreditInfoIncome $income,
    ) {
        $this->ulid = new Ulid($ulidGenerator->generate());
    }

    /**
     * @return string
     */
    public function getUlid(): string
    {
        return $this->ulid->getValue();
    }

    /**
     * @return int
     */
    public function getFICOScore(): int
    {
        return $this->FICOScore->getValue();
    }

    /**
     * @param ClientCreditInfoFICOScore $FICOScore
     * @return CreditInfo
     */
    public function changeFICOScore(ClientCreditInfoFICOScore $FICOScore): CreditInfo
    {
        $this->FICOScore = $FICOScore;
        return $this;
    }

    /**
     * @return string
     */
    public function getSSN(): string
    {
        return $this->SSN->getValue();
    }

    /**
     * @param ClientCreditInfoSSN $SSN
     * @return CreditInfo
     */
    public function changeSSN(ClientCreditInfoSSN $SSN): CreditInfo
    {
        $this->SSN = $SSN;
        return $this;
    }

    /**
     * @return float
     */
    public function getIncome(): float
    {
        return $this->income->getValue();
    }

    /**
     * @param ClientCreditInfoIncome $income
     * @return CreditInfo
     */
    public function changeIncome(ClientCreditInfoIncome $income): CreditInfo
    {
        $this->income = $income;
        return $this;
    }
}
