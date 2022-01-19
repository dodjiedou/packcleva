<?php

namespace App\Repository;

use App\Entity\Beneficiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Beneficiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beneficiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beneficiaire[]    findAll()
 * @method Beneficiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeneficiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beneficiaire::class);
    }

    // /**
    //  * @return Beneficiaire[] Returns an array of Beneficiaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Beneficiaire
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByAge($ageMin,$ageMax,$effectif, $id)
    {
       
        $tab=[];
        $tab2=[];
        $i=0;
        $em = $this->getEntityManager();  
        $beneficiaires = $this->findAll();
        foreach ($beneficiaires as $key => $nom) {
            
            $age=$nom->getAge($nom->getDateNaissance());
            if ($age>=$ageMin && $age<=$ageMax && $i<$effectif) {
               $nom->setClassecde($id);
               $em->persist($nom);
               $em->flush();
               $tab[$i]=$nom;
               $i=$i+1;
            }
           
         }
         if ($effectif>$i) {
            for ($j=0; $j < $i; $j++) { 
            $tab2[$j]=$tab[$j];
            }
         } else {
            for ($j=0; $j < $effectif; $j++) { 
            $tab2[$j]=$tab[$j];
             }
         }
         
         

    return $tab2;      
    }

}
