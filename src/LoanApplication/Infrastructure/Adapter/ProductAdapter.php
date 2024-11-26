<?php

namespace App\LoanApplication\Infrastructure\Adapter;

use App\Products\Application\Service\GetProductService;
use App\LoanApplication\Domain\DTO\ProductInfoDTO;

class ProductAdapter
{
    /**
     * @var GetProductService
     */
    private GetProductService $getProductService;

    /**
     * @param GetProductService $getProductService
     */
    public function __construct(GetProductService $getProductService)
    {
        $this->getProductService = $getProductService;
    }

    /**
     * @param string $productUlid
     * @return ProductInfoDTO
     */
    public function getProductInfo(string $productUlid): ProductInfoDTO
    {
        $product = $this->getProductService->execute($productUlid);

        return new ProductInfoDTO(
            $product->getName(),
            $product->getInterestRate(),
            $product->getLoanTerm()
        );
    }
}
