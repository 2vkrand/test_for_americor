<?php

namespace App\Clients\Infrastructure\Database\Types;

use App\Clients\Domain\ValueObject\ClientFirstName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientFirstNameType extends Type
{
    const string NAME = 'client_first_name';

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
     * @return ClientFirstName
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ClientFirstName
    {
        return new ClientFirstName($value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ClientFirstName) {
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
