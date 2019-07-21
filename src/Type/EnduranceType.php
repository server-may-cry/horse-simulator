<?php declare(strict_types=1);
namespace App\Type;

use App\ValueObject\Endurance;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class EnduranceType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'float';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Endurance
    {
        return Endurance::create((float) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        if (!$value instanceof Endurance) {
            throw new \RuntimeException();
        }

        return $value->get();
    }

    public function getName(): string
    {
        return 'endurance';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
