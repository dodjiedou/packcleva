<?php

namespace App\Controller;
use App\Entity\Contracter;
use App\Form\ContracterFormType;
use App\Form\ContracterMaladieXType;
use app\Form\RapportIndividuelType;
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

        
       
        return $this->render('dashboards/contracter/enregistrement_cas_maladie.html.twig',[
            'form' => $form->createView()]);
    }

    #[Route('/consultation', name: 'consultation')]
    public function consulter(): Response
    {


        $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findAll();
       
        return $this->render('dashboards/contracter/consultation_soin_medicaux.html.twig',[
            'contracters' => $contracters]);
    }


    #[Route('/showconsultation/{id}', name: 'showconsultation')]
    public function show($id): Response
    {
        
            $contracter = $this->getDoctrine()
            ->getRepository(Contracter::class)->find($id);
            
        return $this->render('dashboards/contracter/show_consultation.html.twig', compact('contracter'));
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
            
            return $this->render('dashboards/contracter/contracter_maladiex.html.twig', ['form' => $form->createView(),'contracters'=> $contracters,'maladie'=> $maladie]);
        }
        
        
        return $this->render('dashboards/contracter/contracter_maladiex.html.twig', ['form' => $form->createView(),
            'contracters' => $contracters,'maladie'=> $maladie]);
       
        
    }


     #[Route('/rapport_general', name: 'rapport_general')]
    public function rapport(): Response
    {


        //$contracters = $this->getDoctrine()
            //->getRepository(Contracter::class)->findAll();
       
        return $this->render('contracter/rapport_general.html.twig');
    }


     #[Route('/rapport_individuel', name: 'rapport_individuel')]
    public function rapportIndividuel(Request $request): Response
    {
         $contracters = null;
         $beneficiaire=null;
        $form = $this->createForm(RapportIndividuelType::class);
        
        $entityManager = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $beneficiaire = $form->get("beneficiaire")->getData();
            $date1 = $form->get("date1")->getData();
            $date2 = $form->get("date2")->getData();

            $id=$beneficiaire->getId();
            $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findBy(["beneficiaire"=>$beneficiaire ]);
            //"date"=> ">=$date1" && "date"=> "<=$date2"
           // return $this->redirectToRoute('rapport_individuel', ['contracters'=> $contracters]);
            
            return $this->render('dashboards/contracter/rapport_individuel.html.twig', ['form' => $form->createView(),'contracters'=> $contracters,'beneficiaire'=> $beneficiaire]);
            //'beneficiaire'=> $beneficiaire
        }
        return $this->render('dashboards/contracter/rapport_individuel.html.twig', ['form' => $form->createView(),'contracters'=> $contracters,'beneficiaire'=> $beneficiaire]);
    }

}
