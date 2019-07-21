<?php declare(strict_types=1);
namespace App\Repository;

use App\Entity\Horse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Horse find($id, $lockMode = null, $lockVersion = null)
 * @method null|Horse findOneBy(array $criteria, array $orderBy = null)
 * @method Horse[]    findAll()
 * @method Horse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Horse::class);
    }

    public function findFastestEverFinished(): ?Horse
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.progress = 1500')
            ->orderBy('h.time', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
