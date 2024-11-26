<?php

namespace App\Products\Application\Service;

use App\Products\Application\Request\CreateProductRequest;
use App\Products\Domain\Factory\ProductFactory;
use App\Products\Domain\Repository\ProductRepositoryInterface;
use App\Products\Domain\Entity\Product;
use App\Products\Domain\ValueObject\InterestRate;
use App\Products\Domain\ValueObject\LoanAmount;
use App\Products\Domain\ValueObject\LoanTerm;
use App\Products\Domain\ValueObject\ProductName;

class CreateProductService
{
    /**
     * @var ProductFactory
     */
    private ProductFactory $productFactory;
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @param ProductFactory $productFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductFactory $productFactory, ProductRepositoryInterface $productRepository)
    {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * @param CreateProductRequest $request
     * @return Product
     */
    public function execute(CreateProductRequest $request): Product
    {
        $productName = new ProductName($request->name);
        $interestRate = new InterestRate($request->interestRate);
        $loanTerm = new LoanTerm($request->loanTerm);
        $loanAmount = new LoanAmount($request->loanAmount);

        $product = $this->productFactory->create(
            new ProductName($request->name),
            new InterestRate($request->interestRate),
            new LoanTerm($request->loanTerm),
            new LoanAmount($request->loanAmount)
        );

        $this->productRepository->save($product);

        return $product;
    }
}
