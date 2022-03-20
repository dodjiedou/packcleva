<?php

namespace App\Repository;

use App\Entity\Beneficiaire;
use App\Entity\Categorie;
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


    /*public function findByAge($ageMin,$ageMax,$effectif, $id)
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
    }*/

    public function findLastId()
    {
       
       $codePays="TG";
       $numeroEglise="02";
       $numeroProjet=27;
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT b
                FROM App\Entity\Beneficiaire b
                ORDER BY b.id DESC 
                
            ");
           $beneficiaires=$qr->getResult();
           foreach ($beneficiaires as $key => $value) {
            if ($key==0) {
                $beneficiaire=$value;
            }
              
           }

           if ($qr->getResult()==null) {

              $identifiant=1;
           }else{
            $identifiant=$beneficiaire->getId()+1; 
           }

           //$identifiant=$beneficiaire->getId()+1; 

           $numero= $codePays.$numeroEglise.$numeroProjet.$identifiant;
           if (  $identifiant<10) {
              $numero= $codePays.$numeroEglise.$numeroProjet."0000".$identifiant;
           } elseif ($identifiant<100) {
               $numero= $codePays.$numeroEglise.$numeroProjet."000".$identifiant;
           } elseif ($identifiant<1000) {
               $numero= $codePays.$numeroEglise.$numeroProjet."00".$identifiant;
           } elseif ($identifiant<10000) {
               $numero= $codePays.$numeroEglise.$numeroProjet."0".$identifiant;
           } else{
               $numero= $codePays.$numeroEglise.$numeroProjet.$identifiant;
           } 
           
           

           return $numero;      
   
            
    }


    public function attribuerCategorie($age)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT c
                FROM App\Entity\Categorie c
                WHERE c.ageMin <= :ageBeneficiaire
               AND c.ageMax >= :ageBeneficiaire
                
            ");
            $qr->setParameters(array(
                'ageBeneficiaire' => $age,
                
            ));

         
           $categorie=$qr->getResult();
           

           return $categorie;      
   
            
    }



}
