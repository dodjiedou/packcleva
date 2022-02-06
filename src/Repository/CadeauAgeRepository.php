<?php

namespace App\Repository;

use App\Entity\CadeauAge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadeauAge|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadeauAge|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadeauAge[]    findAll()
 * @method CadeauAge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauAgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadeauAge::class);
    }

    // /**
    //  * @return CadeauAge[] Returns an array of CadeauAge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CadeauAge
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
