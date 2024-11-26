<?php

namespace App\Products\Infrastructure\Database\Types;

use App\Products\Domain\ValueObject\LoanTerm;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class LoanTermType extends Type
{
    const string NAME = 'loan_term';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'INTEGER';
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return LoanTerm
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): LoanTerm
    {
        return new LoanTerm((int) $value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof LoanTerm) {
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
