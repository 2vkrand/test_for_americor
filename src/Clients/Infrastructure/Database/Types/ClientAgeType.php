<?php

namespace App\Clients\Infrastructure\Database\Types;

use App\Clients\Domain\ValueObject\ClientAge;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientAgeType extends Type
{
    const string NAME = 'client_age';

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
     * @return ClientAge
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ClientAge
    {
        return new ClientAge((int) $value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ClientAge) {
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
