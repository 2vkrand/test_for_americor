<?php

namespace App\Products\Infrastructure\Database\Types;

use App\Products\Domain\ValueObject\ProductName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ProductNameType extends Type
{
    const string NAME = 'product_name';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(255)';
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return ProductName
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ProductName
    {
        return new ProductName($value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ProductName) {
            return $value->getValue();
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
