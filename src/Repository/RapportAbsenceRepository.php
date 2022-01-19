<?php

namespace App\Repository;

use App\Entity\RapportAbsence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RapportAbsence|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportAbsence|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportAbsence[]    findAll()
 * @method RapportAbsence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportAbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapportAbsence::class);
    }

    // /**
    //  * @return RapportAbsence[] Returns an array of RapportAbsence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RapportAbsence
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
