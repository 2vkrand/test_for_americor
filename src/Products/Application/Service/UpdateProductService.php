<?php

namespace App\Products\Application\Service;

use App\Products\Application\Request\UpdateProductRequest;
use App\Products\Domain\Repository\ProductRepositoryInterface;
use App\Products\Domain\ValueObject\InterestRate;
use App\Products\Domain\ValueObject\LoanAmount;
use App\Products\Domain\ValueObject\LoanTerm;
use App\Products\Domain\ValueObject\ProductName;

class UpdateProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $ulid
     * @param UpdateProductRequest $request
     * @return void
     */
    public function execute(string $ulid, UpdateProductRequest $request): void
    {
        $product = $this->productRepository->findByUlid($ulid);

        if (!$product) {
            throw new \InvalidArgumentException('Product not found');
        }

        $product->changeName(new ProductName($request->name));
        $product->changeInterestRate(new InterestRate($request->interestRate));
        $product->changeLoanTerm(new LoanTerm($request->loanTerm));
        $product->changeAmount(new LoanAmount($request->loanAmount));

        $this->productRepository->save($product);
    }
}
