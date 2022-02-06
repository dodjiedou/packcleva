<?php

namespace App\Repository;

use App\Entity\Culculum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Culculum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Culculum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Culculum[]    findAll()
 * @method Culculum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CulculumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Culculum::class);
    }

    // /**
    //  * @return Culculum[] Returns an array of Culculum objects
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


     public function findByCategorie($culculum)
    {
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT c
                FROM App\Entity\Culculum c
                WHERE c.categorie = :categ
                AND c.date >  :date1
                ORDER BY c.date ASC
            ");
           $qr->setParameters(array(
                'categ' => $culculum->getCategorie(),
                'date1' => $culculum->getDate()
                
            ));

           return $qr->getResult();      
    }


    
    
}
