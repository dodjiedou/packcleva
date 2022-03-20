<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SensibilisationType;
use App\Entity\Sensibilisation;

class SensibilisationController extends AbstractController
{

    #[Route('/create/sensibilisation', name: 'create_sensibilisation')]
     public function newSensibilisation(Request $request): Response
     {
        $sensibilisation = new Sensibilisation();
         
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(SensibilisationType::class, $sensibilisation);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $sensibilisation = $form->getData();
             $entityManager->persist($sensibilisation);
             $entityManager->flush();  
             $this->addFlash("ajouteSensibilisation", "Enrégistrement effectué avec succès !"); 
             return $this->redirectToRoute('create_sensibilisation');
         }

         return $this->render('admin/sensibilisation/create_sensibilisation.html.twig', [
             'form' => $form->createView()]);
         
     }

     #[Route('/liste/sensibilisation', name: 'liste_sensibilisation')]
     public function lister(): Response
     {
        $sensibilisation = $this->getDoctrine()
             ->getRepository(Sensibilisation::class)->findAll();
         return $this->render('admin/sensibilisation/liste_sensibilisation.html.twig',[
             'sensibilisations' => $sensibilisation]);
        
     }

     #[Route('/show/sensibilisation/{id}', name: 'show_sensibilisation')]
     public function showSensibilisation($id): Response
     {
         $sensibilisation = $this->getDoctrine()
             ->getRepository(Sensibilisation::class)->findById($id);
            
            
         return $this->render('admin/sensibilisation/show_sensibilisation.html.twig',[
             'sensibilisations' => $sensibilisation]);
     }


     #[Route('/edit/sensibilisation/{id}', name: 'edit_sensibilisation')]
   public function editSensibilisation(Request $request,$id): Response
     {
        $sensibilisations = new Sensibilisation();
        
         $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(SensibilisationType::class, $sensibilisations);
        

       $resultat = $this->getDoctrine()
             ->getRepository(Sensibilisation::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $sensibilisation=$value;
            }
          
        $form->get('domaine')->setData($sensibilisation->getDomaine());
        $form->get('theme')->setData($sensibilisation->getTheme());
        $form->get('datePrevue')->setData($sensibilisation->getDatePrevue());
        $form->get('animateur')->setData($sensibilisation->getAnimateur());
        $form->get('facilitateur')->setData($sensibilisation->getFacilitateur());
        $form->get('participantCible')->setData($sensibilisation->getParticipantCible());
        $form->get('dateAnnonce')->setData($sensibilisation->getDateAnnonce());
        $form->get('dateRencontre')->setData($sensibilisation->getDateRencontre());
        $form->get('heureDebut')->setData($sensibilisation->getHeureDebut());
        $form->get('heureFin')->setData($sensibilisation->getHeureFin());
        $form->get('pointcle')->setData($sensibilisation->getPointcle());
        $form->get('depense')->setData($sensibilisation->getDepense());
         $form->get('indicateurImpact')->setData($sensibilisation->getIndicateurImpact());

        
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

        $sensibilisation->setDomaine($form->get('domaine')->getData())  ;
        $sensibilisation->setTheme($form->get('theme')->getData());
        $sensibilisation->setDatePrevue($form->get('datePrevue')->getData());
        $sensibilisation->setAnimateur($form->get('animateur')->getData());
        $sensibilisation->setFacilitateur($form->get('facilitateur')->getData());
        $sensibilisation->setParticipantCible($form->get('participantCible')->getData());
        $sensibilisation->setDateAnnonce($form->get('dateAnnonce')->getData());
        $sensibilisation->setDateRencontre($form->get('dateRencontre')->getData());
        $sensibilisation->setHeureDebut($form->get('heureDebut')->getData());
        $sensibilisation->setHeureFin($form->get('heureFin')->getData());
        $sensibilisation->setPointcle($form->get('pointcle')->getData());
        $sensibilisation->setDepense($form->get('depense')->getData());
        $sensibilisation->setIndicateurImpact($form->get('indicateurImpact')->getData());

         $entityManager->persist($sensibilisation);
          $entityManager->flush();   
         $this->addFlash("modifierSensibilisation", "modification effectuée avec succès !");
             return $this->redirectToRoute('liste_sensibilisation');

         
         }


         return $this->render('admin/sensibilisation/edit_sensibilisation.html.twig', [
             'form' => $form->createView()]);
    }

    #[Route('/delete/sensibilisation/{id}', name: 'delete_sensibilisation')]
     public function deleteSensibilisation($id): Response
     {
       
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Sensibilisation::class)->findById($id);
         foreach ($result as $key => $value) {

             $sensibilisation=$value;
         }
         
         $entityManager->remove($sensibilisation);
         $entityManager->flush();
         $this->addFlash("modifierSensibilisation", "opération effectuée avec succès !");
             return $this->redirectToRoute('liste_sensibilisation');
     }


}
