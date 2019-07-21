<?php declare(strict_types=1);
namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Race find($id, $lockMode = null, $lockVersion = null)
 * @method null|Race findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    private const HORSES_PER_RACE = 8;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Race::class);
    }

    public function findAmountOfActive(): int
    {
        return (int) $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->andWhere('r.isFinished = false')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * No sorting on SQL level. See \App\Entity\Race::getSortedHorses
     *
     * @return Race[]
     */
    public function findAllActive(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isFinished = false')
            ->leftJoin('r.horses', 'h')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * No sorting on SQL level. See \App\Entity\Race::getSortedHorses
     *
     * @return Race[]
     */
    public function findSeveralLastFinished(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isFinished = true')
            ->leftJoin('r.horses', 'h')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(5 * self::HORSES_PER_RACE)
            ->getQuery()
            ->getResult();
    }
}
