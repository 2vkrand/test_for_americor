<?php

namespace App\Products\Application\Service;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\Repository\ProductRepositoryInterface;

class GetProductService
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
     * @return Product
     */
    public function execute(string $ulid): Product
    {
        $product = $this->productRepository->findByUlid($ulid);

        if (!$product) {
            throw new \InvalidArgumentException('Product not found');
        }

        return $product;
    }
}
