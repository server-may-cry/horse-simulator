<?php declare(strict_types=1);
namespace App\Type;

use App\ValueObject\Time;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class TimeType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'float';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Time
    {
        return Time::create((float) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        if (!$value instanceof Time) {
            throw new \RuntimeException();
        }

        return $value->get();
    }

    public function getName(): string
    {
        return 'time';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
