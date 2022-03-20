<?php

namespace App\Repository;

use App\Entity\Absence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Absence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Absence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Absence[]    findAll()
 * @method Absence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

   


    /* public function compterFille($seance)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT COUNT(a)
                FROM App\Entity\Absence a
                WHERE a.beneficiaire.sexe= :x 
                AND a.seance= :s
                
            ");
            $qr->setParameters(array(
                'x' => "F",
                's'=>$seance,
               
                
            ));

           return $qr->getResult();      
      
    }

     public function compterGarcon($seance)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT COUNT(a)
                FROM App\Entity\Absence a
                WHERE a.beneficiaire.sexe= :x 
                AND a.seance= :s
                
            ");
            $qr->setParameters(array(
                'x' => "M",
                's'=>$seance, 
               
                
            ));

           return $qr->getResult();      
      
    }*/

     public function chooseRandomClasse()
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT c
                FROM App\Entity\Classe c
                ORDER BY c.id DESC 
               
                
            ");

           $classes=$qr->getResult();
           foreach ($classes as $key => $value) {
            if ($key==0) {
                $classe=$value;
            }
        }
            
           return $classe;      

     } 

    public function findSeanceByDate($date,$classe)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT s
                FROM App\Entity\Seance s
                WHERE s.classe= :classe 
                AND s.dateSeance= :dates
               
                
            ");
            $qr->setParameters(array(
                'classe' => $classe,
                'dates'=>$date, 
               
                
            ));

            
           return $qr->getResult();      

     } 

     public function findSeanceByPeriode($date1,$date2,$classe)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT s
                FROM App\Entity\Seance s
                WHERE s.classe= :classe 
                AND (s.dateSeance BETWEEN :d1 and :d2)

               
                
            ");

          
            $qr->setParameters(array(
                'classe' => $classe,
                'd1' => $date1,
                'd2' => $date2
               
                
            ));

            
           return $qr->getResult();      

     } 




    public function verifierAbsence($seance,$beneficiaire)
    {
       
       
        
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT a
                FROM App\Entity\Absence a
                WHERE a.beneficiaire= :benef 
                AND a.seance= :seance
               
                
            ");
            $qr->setParameters(array(
                'benef' => $beneficiaire,
                'seance'=>$seance, 
               
                
            ));

            
           return $qr->getResult();      

     }


}