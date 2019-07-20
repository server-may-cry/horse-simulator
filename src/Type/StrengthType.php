<?php declare(strict_types=1);
namespace App\Type;

use App\ValueObject\Strength;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class StrengthType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'float';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Strength
    {
        return Strength::create($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        if (!$value instanceof Strength) {
            throw new \RuntimeException();
        }

        return $value->get();
    }

    public function getName(): string
    {
        return 'strength';
    }
}
