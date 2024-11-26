<?php

 namespace App\Clients\Infrastructure\Database\Types;

 use App\Clients\Domain\ValueObject\ClientCreditInfoFICOScore;
 use Doctrine\DBAL\Platforms\AbstractPlatform;
 use Doctrine\DBAL\Types\Type;

class ClientCreditInfoFICOScoreType extends Type
{
    const string NAME = 'client_credit_info_fico_Score';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return ClientCreditInfoFICOScore
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ClientCreditInfoFICOScore
    {
        return new ClientCreditInfoFICOScore((int) $value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ClientCreditInfoFICOScore) {
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
