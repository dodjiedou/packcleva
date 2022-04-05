<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RapportAbsenceType;
use App\Form\RapportAbsenceCategorieType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\RapportAbsence;
use App\Entity\RapportAbsenceCategorie;
use App\Entity\Classe;
use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */


class RapportAbsenceController extends AbstractController
{

     /*#[Route('/rapport', name: 'rapport_absence')]
     public function newRapportClasse(Request $request): Response
     {
        $rapportAbsence = new RapportAbsence();
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(RapportAbsenceType::class, $rapportAbsence);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $rapportAbsence = $form->getData();
             $entityManager->persist($rapportAbsence);
             $entityManager->flush();
             return $this->redirectToRoute('rapport_absence');
         }

         return $this->render('admin/rapport_absence/rapport_absence.html.twig', ['form' => $form->createView()]);
        
     }



     #[Route('/absence_classe', name: 'absence_classe')]
    public function rapportClasse(Request $request): Response
    {
       $rapports =$this->getDoctrine()
            ->getRepository(RapportAbsence::class)->findAll();

        $form = $this->createFormBuilder()
              ->add('classe', EntityType::class, ['class' => Classe::class,
                'choice_label' => 'nom',
                 'label' => '',
                //'placeholder' => 'choisir'
            ])

          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $classe = $form->get("classe")->getData();
           
            $rapports = $this->getDoctrine()
            ->getRepository(RapportAbsence::class)->findBy(["classe"=>$classe]);
            
            return $this->render('admin/rapport_absence/absence_classe.html.twig', ['form' => $form->createView(),'rapports'=> $rapports]);
        }
        
       
         
       
       return $this->render('admin/rapport_absence/absence_classe.html.twig', ['form' => $form->createView(),'rapports'=> $rapports]);
    }


   #[Route('/absence_categorie', name: 'absence_categorie')]
     public function newRapportCategorie(Request $request): Response
     {
        $rapportAbsenceCategorie = new RapportAbsenceCategorie();
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(RapportAbsenceCategorieType::class, $rapportAbsenceCategorie);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $rapportAbsenceCategorie = $form->getData();
             $entityManager->persist($rapportAbsenceCategorie);
             $entityManager->flush();
             return $this->redirectToRoute('absence_categorie');
         }

         return $this->render('admin/rapport_absence/rapport_absence_categorie.html.twig', ['form' => $form->createView()]);
        
     }


     #[Route(' /rapport_absence_categorie', name: 'rapport_absence_categorie')]
    public function rapportCategorie(Request $request): Response
    {
       $rapports =$this->getDoctrine()
            ->getRepository(RapportAbsenceCategorie::class)->findAll();

        $form = $this->createFormBuilder()
              ->add('categorie', EntityType::class, ['class' => Categorie::class,
                'choice_label' => 'nom',
                 'label' => '',
                //'placeholder' => 'choisir'
            ])

          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $form->get("categorie")->getData();
           
            $rapports = $this->getDoctrine()
            ->getRepository(RapportAbsenceCategorie::class)->findBy(["categorie"=>$categorie]);
            
            return $this->render('admin/rapport_absence/absence_categorie.html.twig', ['form' => $form->createView(),'rapports'=> $rapports]);
        }
        
       
         
       
       return $this->render('admin/rapport_absence/absence_categorie.html.twig', ['form' => $form->createView(),'rapports'=> $rapports]);
    }*/






}
