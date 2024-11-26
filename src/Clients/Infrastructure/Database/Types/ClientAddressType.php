<?php

namespace App\Clients\Infrastructure\Database\Types;

use App\Clients\Domain\ValueObject\ClientAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientAddressType extends Type
{
    const string NAME = 'client_address';

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
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return ClientAddress
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ClientAddress
    {
        $data = json_decode($value, true);
        return new ClientAddress($data['city'], $data['state'], $data['zip']);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof ClientAddress) {
            return json_encode([
                'city' => $value->getCity(),
                'state' => $value->getState(),
                'zip' => $value->getZip(),
            ]);
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
