<?php

namespace App\Shared\Infrastructure\Database\Types;

use App\Shared\Domain\ValueObject\Ulid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UlidType extends Type
{
    const string NAME = 'ulid';

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(26)';
    }

    /**
     * Преобразование из базы данных в объект ULID.
     * @param $value
     * @param AbstractPlatform $platform
     * @return Ulid|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Ulid
    {
        if ($value === null) {
            return null;
        }

        return new Ulid($value);
    }

    /**
     * Преобразование объекта Ulid в строку для сохранения в базу данных.
     * @param $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Ulid) {
            return $value->getValue();
        }

        return $value; // На случай, если это уже строка
    }

    /**
     * Возвращаем уникальное имя типа.
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Указывает, что этот тип требует комментарий SQL для корректной обработки.
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
