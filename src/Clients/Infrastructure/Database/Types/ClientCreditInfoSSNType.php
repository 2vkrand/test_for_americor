<?php

namespace App\Clients\Infrastructure\Database\Types;

use App\Clients\Domain\ValueObject\ClientCreditInfoSSN;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientCreditInfoSSNType extends Type
{
    const string NAME = 'client_credit_info_ssn';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(9)';
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return ClientCreditInfoSSN
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ClientCreditInfoSSN
    {
        return new ClientCreditInfoSSN($value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ClientCreditInfoSSN) {
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
