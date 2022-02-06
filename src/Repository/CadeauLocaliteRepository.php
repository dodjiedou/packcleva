<?php

namespace App\Repository;

use App\Entity\CadeauLocalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadeauLocalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadeauLocalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadeauLocalite[]    findAll()
 * @method CadeauLocalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauLocaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadeauLocalite::class);
    }

    // /**
    //  * @return CadeauLocalite[] Returns an array of CadeauLocalite objects
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
    public function findOneBySomeField($value): ?CadeauLocalite
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
