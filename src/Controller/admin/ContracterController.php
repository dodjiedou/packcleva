<?php

namespace App\Controller\admin;
use App\Entity\Contracter;
use App\Entity\Maladie;
use App\Entity\Beneficiaire;
use App\Form\ContracterFormType;
use App\Form\ContracterMaladieXType;
use app\Form\RapportType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContracterController extends AbstractController
{
    
/*
  /contracter
  /consultation
  /showconsultation/{id}
  /contracter_maladie
  /rapport_general
  /rapport_individuel

*/


    #[Route('/contracter', name: 'contracter')]
    public function index(Request $request): Response
    {


        $contracter = new Contracter();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ContracterFormType::class, $contracter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contracter = $form->getData();
            $entityManager->persist($contracter);
            $entityManager->flush();
            return $this->redirectToRoute('contracter');
        }

        
       
        return $this->render('admin/contracter/enregistrement_cas_maladie.html.twig',[
            'form' => $form->createView()]);
    }

    #[Route('/consultation', name: 'consultation')]
    public function consulter(): Response
    {


        $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findAll();
       
        return $this->render('admin/contracter/consultation_soin_medicaux.html.twig',[
            'contracters' => $contracters]);
    }


    #[Route('/showconsultation/{id}', name: 'showconsultation')]
    public function show($id): Response
    {
        
            $contracter = $this->getDoctrine()
            ->getRepository(Contracter::class)->find($id);
            
        return $this->render('admin//contracter/show_consultation.html.twig', compact('contracter'));
    }

    #[Route('/contracter_maladie', name: 'contracter_maladie')]
    public function contracter(Request $request): Response
    {

         $contracter = new Contracter();
        $form = $this->createForm(ContracterMaladieXType::class, $contracter);
        $contracters = null;
        $maladie = null;
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $maladie = $form->get("maladie")->getData();
           
            $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findBy(["maladie"=>$maladie]);
            
            return $this->render('admin//contracter/contracter_maladiex.html.twig', ['form' => $form->createView(),'contracters'=> $contracters,'maladie'=> $maladie]);
        }
        
        
        return $this->render('admin/contracter/contracter_maladiex.html.twig', ['form' => $form->createView(),
            'contracters' => $contracters,'maladie'=> $maladie]);
       
        
    }


     #[Route('/rapport_general', name: 'rapport_general')]
    public function rapport(): Response
    {
       $casMaladie =[[]];
       
         $maladies=$this->getDoctrine()->getRepository(Maladie::class)->findAll();
         foreach ($maladies as $key => $nom) {
            $beneficiaireM=0;
            $beneficiaireF=0;
            $casF=0;
            $casM=0;
            $montant=0;
             $contracters=$this->getDoctrine()->getRepository(Contracter::class)->findBy(['maladie'=>$nom]);
             foreach ($contracters as $benef => $contracter) {

                $contract=$this->getDoctrine()->getRepository(Contracter::class)->findById($contracter);
             
                if ($contracter->getBeneficiaire()->getSexe()=='M'&& $contract==null ) {
                    $beneficiaireM=$beneficiaireM+1;
                }
                if ($contracter->getBeneficiaire()->getSexe()=='F' && $contract==null) 
                {
                     $beneficiaireF=$beneficiaireF+1;
                }
                if ($contracter->getBeneficiaire()->getSexe()=='M') {
                    $casM=$casM+1;
                } else {
                     $casF=$casF+1;
                }
                $montant=$montant+$contracter->getMontantSoin();
             }
              $casMaladie[$key][0]=$key+1;
             $casMaladie[$key][1]=$nom->getNom();
             $casMaladie[$key][2]=$beneficiaireF;
             $casMaladie[$key][3]=$beneficiaireM;
              $casMaladie[$key][4]=($beneficiaireF+$beneficiaireM);
             $casMaladie[$key][5]=$casF;
             $casMaladie[$key][6]=$casM;
             $casMaladie[$key][7]=($casF+$casM);
             $casMaladie[$key][8]=$montant;     

         }
       
        return $this->render('admin/contracter/rapport_general.html.twig',compact('casMaladie'));
    }

     #[Route('/rapport_individuel', name: 'rapport_individuel')]
    public function rapportIndividuel(Request $request): Response
    {
        
         $contracters = null;
         $beneficiaire=null;

        $form2 = $this->createFormBuilder()
             ->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Nom du Bénéficiaire',
            ])
             ->add('date1', DateType::class, [
                'label' => 'De',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('date2', DateType::class, [
                'label' => 'A',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();
       // $form2 = $this->createForm(RapportType::class);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {

            $beneficiaire = $form2->get("beneficiaire")->getData();
            $date1 = $form2->get("date1")->getData();
            $date2 = $form2->get("date2")->getData();
            $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findByBeneficiaire($beneficiaire,$date1,$date2);
            $form2 = $this->createForm(RapportType::class);
            return $this->render('admin/contracter/rapport_individuel.html.twig', ['form'=>$form2->createView(),'contracters'=> $contracters,'beneficiaire'=> $beneficiaire]);
            
        }
        return $this->render('admin/contracter/rapport_individuel.html.twig', ['form'=>$form2->createView(),'contracters'=> $contracters,'beneficiaire'=> $beneficiaire]);
    }



    
}
