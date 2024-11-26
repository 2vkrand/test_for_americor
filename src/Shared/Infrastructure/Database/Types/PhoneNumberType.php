<?php

namespace App\Shared\Infrastructure\Database\Types;

use App\Shared\Domain\ValueObject\PhoneNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PhoneNumberType extends Type
{
    const string NAME = 'phone_number';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(20)';
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return PhoneNumber
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): PhoneNumber
    {
        return new PhoneNumber($value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof PhoneNumber) {
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
