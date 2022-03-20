<?php

namespace App\Repository;

use App\Entity\Prendre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prendre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prendre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prendre[]    findAll()
 * @method Prendre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrendreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prendre::class);
    }

    // /**
    //  * @return Prendre[] Returns an array of Prendre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prendre
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLastVaccin()
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT v
                FROM App\Entity\Vaccin v
                ORDER BY v.id ASC 
                
            ");
           $vaccins=$qr->getResult();
           foreach ($vaccins as $key => $value) {
            if ($key==0) {
                $vaccin=$value;
            }
              
           } 

           return $vaccin;      
   
            
    }

    public function findPrendreByBeneficiaire($beneficiaire,$vaccin)
    {
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT p
                FROM App\Entity\Prendre p
                WHERE p.beneficiaire = :beneficiaire 
                AND p.vaccin = :vaccin 
                ORDER BY p.id ASC
            ");
           $qr->setParameters(array(
                'beneficiaire' => $beneficiaire,
                'vaccin' => $vaccin,
               
            ));

           return $qr->getResult();      
    }


     public function findDose($beneficiaire,$vaccin)
    {
        $em = $this->getEntityManager();
        $dose=0;
        
           $qr = $em->createQuery("
                SELECT p
                FROM App\Entity\Prendre p
                WHERE p.beneficiaire = :beneficiaire 
                AND p.vaccin = :vaccin 
                ORDER BY p.id DESC
            ");
           $qr->setParameters(array(
                'beneficiaire' => $beneficiaire,
                'vaccin' => $vaccin,
               
            ));

           $vaccinsDuBeneficiaires=$qr->getResult();   
           if ($vaccinsDuBeneficiaires == null) {

              $dose=1;

            }else{

                 
               foreach ($vaccinsDuBeneficiaires as $key => $value) {
                    if ($key==0) {
                        $dernierDose=$value;
                    }

                }
                $dose=$dernierDose->getDose()+1;
           
       }

       return $dose;
   
    }



}




