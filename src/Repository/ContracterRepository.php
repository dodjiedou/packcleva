<?php

namespace App\Repository;

use App\Entity\Contracter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contracter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contracter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contracter[]    findAll()
 * @method Contracter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContracterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contracter::class);
    }

    // /**
    //  * @return Contracter[] Returns an array of Contracter objects
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
    public function findOneBySomeField($value): ?Contracter
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
