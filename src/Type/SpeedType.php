<?php declare(strict_types=1);
namespace App\Type;

use App\ValueObject\Speed;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class SpeedType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'float';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Speed
    {
        return Speed::create((float) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        if (!$value instanceof Speed) {
            throw new \RuntimeException();
        }

        return $value->get();
    }

    public function getName(): string
    {
        return 'speed';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
