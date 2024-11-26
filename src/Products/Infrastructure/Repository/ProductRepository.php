<?php

namespace App\Products\Infrastructure\Repository;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param string $ulid
     * @return Product|null
     */
    public function findByUlid(string $ulid): ?Product
    {
        return $this->findOneBy(['ulid' => $ulid]);
    }

    /**
     * @param Product $product
     * @return void
     */
    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Product $product
     * @return void
     */
    public function delete(Product $product): void
    {
        $this->getEntityManager()->remove($product);
        $this->getEntityManager()->flush();
    }
}
