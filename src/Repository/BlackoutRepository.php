<?php

namespace App\Repository;

use App\Entity\Blackout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blackout>
 */
class BlackoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blackout::class);
    }

    public function findByPeriod(\DateTime $startDate): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.start_date >= :startDate')
            ->andWhere('b.end_date IS NULL OR b.end_date >= :startDate')
            ->setParameter('startDate', $startDate)
            ->orderBy('b.start_date', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Blackout[] Returns an array of Blackout objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Blackout
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
