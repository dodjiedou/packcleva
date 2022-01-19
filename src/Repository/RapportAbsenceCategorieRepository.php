<?php

namespace App\Repository;

use App\Entity\RapportAbsenceCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RapportAbsenceCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportAbsenceCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportAbsenceCategorie[]    findAll()
 * @method RapportAbsenceCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportAbsenceCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapportAbsenceCategorie::class);
    }

    // /**
    //  * @return RapportAbsenceCategorie[] Returns an array of RapportAbsenceCategorie objects
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
    public function findOneBySomeField($value): ?RapportAbsenceCategorie
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
