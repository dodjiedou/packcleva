<?php

namespace App\Repository;

use App\Entity\Sensibilisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sensibilisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sensibilisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sensibilisation[]    findAll()
 * @method Sensibilisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensibilisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sensibilisation::class);
    }

    // /**
    //  * @return Sensibilisation[] Returns an array of Sensibilisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sensibilisation
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
