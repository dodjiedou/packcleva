<?php

namespace App\Repository;

use App\Entity\Classe;
use App\Entity\Absence;
use App\Entity\Seance;
use App\Entity\Beneficiaire;
use App\Repository\BeneficiaireRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classe[]    findAll()
 * @method Classe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    // /**
    //  * @return Classe[] Returns an array of Classe objects
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


     public function fullClasse($categorie)
    {
       
        $tab=[];
        $tab2=[];
        $i=0;
        $em = $this->getEntityManager();  
        $beneficiaires = $this->findAll();

           foreach ($beneficiaires as $key => $value) {
            
               $beneficiaire=$value;
           }

          $qr = $em->createQuery("
                SELECT b
                FROM App\Entity\Beneficiaire b
                WHERE c.beneficiaire = :benef 
                AND c.maladie= :mal
                AND c.id < :id
            ");
           $qr->setParameters(array(
                'benef' => $contracter->getBeneficiaire(),
                'mal'=>$contracter->getMaladie(),
                'id' => $contracter->getId()
                
            ));

           return $qr->getResult();   

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


    
     public function findLastSeance()
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT s
                FROM App\Entity\Seance s
                ORDER BY s.id DESC 
                
            ");
           $seances=$qr->getResult();
           foreach ($seances as $key => $value) {
            if ($key==0) {
                $seance=$value;
            }
              
           } 

           return $seance;      
   
            
    }

      public function findAbsence($seance,$beneficiaire)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT a
                FROM App\Entity\Absence a
                WHERE a.beneficiaire= :b 
                AND a.seance= :s
                
            ");
            $qr->setParameters(array(
                'b' => $beneficiaire,
                's'=>$seance,
               
                
            ));

            $absences=$qr->getResult();
           foreach ($absences as $key => $value) {
            
                return $absence=$value;
              
           } 



           //return $absence;      
      
    }




   
}
