<?php

namespace App\Products\Domain\Repository;

use App\Products\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * Найти продукт по ULID.
     *
     * @param string $ulid
     * @return Product|null
     */
    public function findByUlid(string $ulid): ?Product;

    /**
     * Сохранить продукт.
     *
     * @param Product $product
     * @return void
     */
    public function save(Product $product): void;

    /**
     * Удалить продукт.
     *
     * @param Product $product
     * @return void
     */
    public function delete(Product $product): void;
}
