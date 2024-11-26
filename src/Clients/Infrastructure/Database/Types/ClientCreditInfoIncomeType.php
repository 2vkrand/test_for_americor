<?php

namespace App\Clients\Infrastructure\Database\Types;

use App\Clients\Domain\ValueObject\ClientCreditInfoIncome;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientCreditInfoIncomeType extends Type
{
    const string NAME = 'client_credit_info_income';

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
     * @return ClientCreditInfoIncome
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ClientCreditInfoIncome
    {
        return new ClientCreditInfoIncome((float) $value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ClientCreditInfoIncome) {
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
