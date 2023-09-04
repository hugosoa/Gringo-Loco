<?php

namespace App\Repository;

use App\Entity\ActuNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActuNews>
 *
 * @method ActuNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActuNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActuNews[]    findAll()
 * @method ActuNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActuNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActuNews::class);
    }


    //    /**
    //     * @return ActuNews[] Returns an array of ActuNews objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ActuNews
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
