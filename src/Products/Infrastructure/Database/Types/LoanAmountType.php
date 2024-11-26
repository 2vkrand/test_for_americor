<?php

namespace App\Products\Infrastructure\Database\Types;

use App\Products\Domain\ValueObject\LoanAmount;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class LoanAmountType extends Type
{
    const string NAME = 'amount';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'FLOAT';
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return LoanAmount
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): LoanAmount
    {
        return new LoanAmount((float) $value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return float|mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof LoanAmount) {
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
