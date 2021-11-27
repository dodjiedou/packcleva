<?php

namespace App\Repository;

use App\Entity\Creer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Creer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creer[]    findAll()
 * @method Creer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creer::class);
    }

    // /**
    //  * @return Creer[] Returns an array of Creer objects
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
    public function findOneBySomeField($value): ?Creer
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
