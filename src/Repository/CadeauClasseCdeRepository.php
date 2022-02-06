<?php

namespace App\Repository;

use App\Entity\CadeauClasseCde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadeauClasseCde|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadeauClasseCde|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadeauClasseCde[]    findAll()
 * @method CadeauClasseCde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauClasseCdeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadeauClasseCde::class);
    }

    // /**
    //  * @return CadeauClasseCde[] Returns an array of CadeauClasseCde objects
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
    public function findOneBySomeField($value): ?CadeauClasseCde
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
