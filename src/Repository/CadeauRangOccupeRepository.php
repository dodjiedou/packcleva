<?php

namespace App\Repository;

use App\Entity\CadeauRangOccupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadeauRangOccupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadeauRangOccupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadeauRangOccupe[]    findAll()
 * @method CadeauRangOccupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauRangOccupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadeauRangOccupe::class);
    }

    // /**
    //  * @return CadeauRangOccupe[] Returns an array of CadeauRangOccupe objects
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
    public function findOneBySomeField($value): ?CadeauRangOccupe
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
