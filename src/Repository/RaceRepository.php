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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Race::class);
    }

    /**
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
     * @return Race[]
     */
    public function findLastFiveFinished(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isFinished = true')
            ->leftJoin('r.horses', 'h')
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
