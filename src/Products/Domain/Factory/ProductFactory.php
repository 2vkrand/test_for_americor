<?php

namespace App\Products\Domain\Factory;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\ValueObject\ProductName;
use App\Products\Domain\ValueObject\InterestRate;
use App\Products\Domain\ValueObject\LoanTerm;
use App\Products\Domain\ValueObject\LoanAmount;
use App\Shared\Domain\ValueObject\Ulid;
use App\Clients\Domain\Service\UlidGeneratorInterface;

readonly class ProductFactory
{
    /**
     * @param UlidGeneratorInterface $ulidGenerator
     */
    public function __construct(readonly private UlidGeneratorInterface $ulidGenerator)
    {
    }

    /**
     * @param ProductName $name
     * @param InterestRate $interestRate
     * @param LoanTerm $loanTerm
     * @param LoanAmount $amount
     * @return Product
     */
    public function create(
        ProductName  $name,
        InterestRate $interestRate,
        LoanTerm     $loanTerm,
        LoanAmount   $amount
    ): Product {
        $ulid = new Ulid($this->ulidGenerator->generate());

        return new Product($ulid, $name, $interestRate, $loanTerm, $amount);
    }
}
