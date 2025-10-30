<?php

namespace App\Repository;

use App\Entity\Building;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Building>
 */
class BuildingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Building::class);
    }

    public function findByCoordinates(float $lat, float $lon): ?Building
    {
        $epsilon = 0.00001;

        return $this->createQueryBuilder('b')
            ->andWhere('b.lat BETWEEN :lat_min AND :lat_max')
            ->andWhere('b.lon BETWEEN :lon_min AND :lon_max')
            ->setParameter('lat_min', $lat - $epsilon)
            ->setParameter('lat_max', $lat + $epsilon)
            ->setParameter('lon_min', $lon - $epsilon)
            ->setParameter('lon_max', $lon + $epsilon)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Building[] Returns an array of Building objects
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

    //    public function findOneBySomeField($value): ?Building
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
