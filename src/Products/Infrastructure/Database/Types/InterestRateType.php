<?php

namespace App\Products\Infrastructure\Database\Types;

use App\Products\Domain\ValueObject\InterestRate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class InterestRateType extends Type
{
    const string NAME = 'interest_rate';

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
     * @return InterestRate
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): InterestRate
    {
        return new InterestRate((float) $value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof InterestRate) {
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
