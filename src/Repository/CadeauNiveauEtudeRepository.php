<?php

namespace App\Repository;

use App\Entity\CadeauNiveauEtude;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadeauNiveauEtude|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadeauNiveauEtude|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadeauNiveauEtude[]    findAll()
 * @method CadeauNiveauEtude[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauNiveauEtudeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadeauNiveauEtude::class);
    }

    // /**
    //  * @return CadeauNiveauEtude[] Returns an array of CadeauNiveauEtude objects
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
    public function findOneBySomeField($value): ?CadeauNiveauEtude
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
