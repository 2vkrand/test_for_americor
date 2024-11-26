<?php

namespace App\Shared\Infrastructure\Database\Types;

use App\Shared\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EmailType extends Type
{
    const string NAME = 'email';

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
     * @return Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return new Email($value);
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof Email) {
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
