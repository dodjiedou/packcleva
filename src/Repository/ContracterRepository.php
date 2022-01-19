<?php

namespace App\Repository;

use App\Entity\Contracter;
use App\Entity\Prendre;
use app\Form\RapportIndividuelType;
use App\Entity\Maladie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contracter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contracter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contracter[]    findAll()
 * @method Contracter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContracterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contracter::class);
    }

    

    public function findByBeneficiaire($beneficiaire,$date1,$date2)
    {
        $em = $this->getEntityManager();
        /*$qb = $em->createQueryBuilder();   
        $qb->select('c')
           ->from('Contracter','c')
           ->Where(
                $qb->expr()->orX
               (
                    $qb->expr()->eq('c.beneficiaire', '?1'),
                    $qb->expr()->between('c.date', '?2','?3')
                     
               )
            )
           ->setParameters(array(
                '1' => $beneficiaire,
                '2' => $date1,
                '3' => $date2
            ))
           ->getQuery()
           ;
           return $qb->getResult();*/

           $qr = $em->createQuery("
                SELECT c
                FROM App\Entity\Contracter c
                WHERE c.beneficiaire = :benef 
                AND (c.date BETWEEN :d1 and :d2)
            ");
           $qr->setParameters(array(
                'benef' => $beneficiaire,
                'd1' => $date1,
                'd2' => $date2
            ));

           return $qr->getResult();      
    }


    public function findById($contracter)
    {
        $em = $this->getEntityManager();
        
           $qr = $em->createQuery("
                SELECT c
                FROM App\Entity\Contracter c
                WHERE c.beneficiaire = :benef 
                AND c.id > :id
            ");
           $qr->setParameters(array(
                'benef' => $contracter->getBeneficiaire(),
                'id' => $contracter->getId()
                
            ));

           return $qr->getResult();      
    }


}
    