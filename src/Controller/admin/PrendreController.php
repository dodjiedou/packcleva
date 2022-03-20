<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PrendreFormType;
use App\Entity\Prendre;
use App\Repository\BeneficiaireRepository;
use App\Repository\VaccinRepository;
use App\Entity\Vaccin;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Form\RapportVaccinationType;


class PrendreController extends AbstractController
{

    /*
        /vaccination
        /rapport_vaccination
    */

    #[Route('/vaccination', name: 'vaccination')]
    public function vaccination(Request $request): Response
    {

        $prendre = new Prendre();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(PrendreFormType::class, $prendre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $prendre = $form->getData();
            $entityManager->persist($prendre);
            $entityManager->flush();
            return $this->redirectToRoute('vaccination');
        }

        return $this->render('admin/prendre/vaccination.html.twig', ['form' => $form->createView()]);
        
    }

     #[Route('/ajouterVaccination/{idb}/{idv}', name: 'ajouter_vaccination')]
    public function ajoutervaccination(Request $request,$idv,$idb): Response
    {
        $prendre = new Prendre();
        $entityManager = $this->getDoctrine()->getManager();
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findById($idb);

       foreach ($beneficiaires as $key => $value) {

           $beneficiaire=$value;
           
        }
       $vaccins = $this->getDoctrine()->getRepository(Vaccin::class)->findById($idv);
        foreach ($vaccins as $key => $value) {
           $vaccin=$value;
        }

       $dose=$this->getDoctrine()->getRepository(Prendre::class)->findDose($beneficiaire,$vaccin);

            if ($dose>$vaccin->getNombreDeDose()) {
            $this->addFlash("ajouterVaccin", "Ce bénéficiaire a réçu toutes ses doses,Enregistrement impossible !");
            
         $form = $this->createFormBuilder()
          ->add('beneficiaire', EntityType::class, [
            'class' => Beneficiaire ::class,
            'choice_label' => function($beneficiaire){
             return $beneficiaire->getNumero()."  "."(".$beneficiaire->getNom().")";
         },
            'label' => 'Numero du Bénéficiaire',
             'disabled' => true,
             'data' =>$beneficiaire,
            'query_builder' =>function(BeneficiaireRepository $beneficiaireRepo){
                return $beneficiaireRepo->createQueryBuilder('b')->orderBy('b.nom','ASC');

            },
        ])
             
            ->add('vaccin', EntityType::class, [
            'class' => Vaccin ::class,
            'choice_label' =>'nom',
             'disabled' => true,
            'data' =>$vaccin,
            'query_builder' =>function(VaccinRepository $vaccinRepo){
                return $vaccinRepo->createQueryBuilder('v')->orderBy('v.nom','ASC');

            },
        ])
            
            ->add('dose', IntegerType::class, [
             'disabled' => true,
              'data' =>$dose,
             ])
            ->add('datep', DateType::class, [
                'label' => 'Date de vaccination',
                'widget' => 'single_text',
                 'input' => 'string'
                
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                 'disabled' => true,
                'attr'=>['class'=>'btn btn-info w-100']])
        
            ->getForm();
                
            }else{
            
         $form = $this->createFormBuilder()
          ->add('beneficiaire', EntityType::class, [
            'class' => Beneficiaire ::class,
            'choice_label' => function($beneficiaire){
             return $beneficiaire->getNumero()."  "."(".$beneficiaire->getNom().")";
         },
            'label' => 'Numero du Bénéficiaire',
             'disabled' => true,
             'data' =>$beneficiaire,
            'query_builder' =>function(BeneficiaireRepository $beneficiaireRepo){
                return $beneficiaireRepo->createQueryBuilder('b')->orderBy('b.nom','ASC');

            },
        ])
             
            ->add('vaccin', EntityType::class, [
            'class' => Vaccin ::class,
            'choice_label' =>'nom',
             'disabled' => true,
            'data' =>$vaccin,
            'query_builder' =>function(VaccinRepository $vaccinRepo){
                return $vaccinRepo->createQueryBuilder('v')->orderBy('v.nom','ASC');

            },
        ])
            
            ->add('dose', IntegerType::class, [
             'disabled' => true,
              'data' =>$dose,
             ])
            ->add('datep', DateType::class, [
                'label' => 'Date de vaccination',
                'widget' => 'single_text',
                 'input' => 'string'
                
            ])
            
             ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',

                'attr'=>['class'=>'btn btn-info w-100']])
        
            ->getForm();
            }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
  
            $prendre->setBeneficiaire($form->get('beneficiaire')->getData())  ;
            $prendre->setVaccin($form->get('vaccin')->getData());
            $prendre->setDatep($form->get('datep')->getData());
            $prendre->setDose($form->get('dose')->getData());
           if ($dose<=$vaccin->getNombreDeDose()) {
               $entityManager->persist($prendre);
               $entityManager->flush();
           }
            
            return $this->redirectToRoute('rapport_vaccination');
            
        }

        
       
        return $this->render('admin/prendre/vaccination.html.twig',[
            'form' => $form->createView()]);
    }





     #[Route('/rapport_vaccination', name: 'rapport_vaccination')]
    public function rapport(Request $request): Response
    {

         $prendre = new Prendre();
        $form = $this->createForm(RapportVaccinationType::class, $prendre);
        $vaccin =  $this->getDoctrine()
            ->getRepository(Prendre::class)->findLastVaccin();
       

         /* Récuperation de tous les bénéficiaires qui n'ont jamais été vacciné */   
        $beneficiaireNonVaccine =[];
        $beneficiaireVaccine =[];
       $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
       foreach ($beneficiaires as $key => $beneficiaire) {

        $vaccinsDuBeneficiaire = $this->getDoctrine()
             ->getRepository(Prendre::class)->findPrendreByBeneficiaire($beneficiaire,$vaccin);

            if ($vaccinsDuBeneficiaire == null) {

               array_push($beneficiaireNonVaccine, $beneficiaire);

            }else{

                array_push( $beneficiaireVaccine, $beneficiaire);

            }
           
       }
       /* !end */
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $vaccin = $form->get("vaccin")->getData();
           
            
            /* Récuperation de tous les bénéficiaires qui n'ont jamais été vacciné */   
        $beneficiaireNonVaccine =[];
        $beneficiaireVaccine =[];
       $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
       foreach ($beneficiaires as $key => $beneficiaire) {

        $vaccinsDuBeneficiaire = $this->getDoctrine()
             ->getRepository(Prendre::class)->findPrendreByBeneficiaire($beneficiaire,$vaccin);

            if ($vaccinsDuBeneficiaire == null) {

               array_push($beneficiaireNonVaccine, $beneficiaire);

            }else{

                array_push( $beneficiaireVaccine, $beneficiaire);

            }
           
       }
       /* !end */

                
            return $this->render('admin/prendre/rapport_vaccination.html.twig', ['form' => $form->createView(),'vaccin'=>$vaccin,'beneficiaireNonVaccines'=>$beneficiaireNonVaccine,'beneficiaireVaccines'=>$beneficiaireVaccine]);
        }
        
         return $this->render('admin/prendre/rapport_vaccination.html.twig', ['form' => $form->createView(),'vaccin'=>$vaccin,'beneficiaireNonVaccines'=>$beneficiaireNonVaccine,'beneficiaireVaccines'=>$beneficiaireVaccine]);
       
        
    }


     #[Route('/mesVaccinations/{idv}/{idb}', name: 'mesVaccinations')]
   public function mesVaccinations(Request $request,$idv,$idb): Response
     {

      $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findById($idb);
        foreach ($beneficiaires as $key => $value) {
           $beneficiaire=$value;
        }

        $vaccins = $this->getDoctrine()->getRepository(Vaccin::class)->findById($idv);
        foreach ($vaccins as $key => $value) {
           $vaccin=$value;
        }

        $prendres =$this->getDoctrine()
             ->getRepository(Prendre::class)->findPrendreByBeneficiaire($beneficiaire,$vaccin);

             
       
          return $this->render('admin/prendre/mes_vaccination.html.twig',[
             'prendres' => $prendres,
             'vaccin'=>$vaccin,
             'beneficiaire'=>$beneficiaire,
             
         ]);
    }




}
