<?php

namespace App\Controller\admin;

use App\Entity\Personne;
use App\Entity\PdfService;
use App\Entity\Beneficiaire;
use App\Entity\Categorie;
use Symfony\Component\Form\Form;
use App\Form\BeneficiaireFormType;
use App\Repository\BeneficiaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

//**
 // * Require ROLE_ADMIN for *every* controller method in this class.
  //*
 // * @IsGranted("ROLE_COORDONNATEUR")
  //*/



class BeneficiaireController extends AbstractController
 {

     /*
         /list_beneficiaire
         /creerbeneficiaire
        /showbeneficiaire/{num}
         /edit_beneficiaire
        /delete_beneficiaire/{num}
     */
   

     #[Route('/liste/beneficiaire', name: 'list_beneficiaire')]
     public function list(): Response
     {
        //$this->denyAccessUnlessGranted('ROLE_COORDONNATEUR');

    // or add an optional message - seen by developers
    //$this->denyAccessUnlessGranted('ROLE_COORDONNATEUR', null, 'User tried to access a page without having ROLE_COORDONNATEUR');
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findAll();
         return $this->render('admin/beneficiaire/list_beneficiaire.html.twig',[
             'beneficiaires' => $beneficiaires]);
        
     }

     #[Route('/creerbeneficiaire', name: 'creerbeneficiaire')]
     public function new(Request $request): Response
     {
        $beneficiaire = new Beneficiaire();
        
         $entityManager = $this->getDoctrine()->getManager();
         $numero = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findLastId();
         $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);
        

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $beneficiaire->setNom($form->get('nom')->getData())  ;
        $beneficiaire->setPrenom($form->get('prenom')->getData());
        $beneficiaire->setTelephone($form->get('telephone')->getData());
        $beneficiaire->setEmail($form->get('email')->getData());
        $beneficiaire->setDateNaissance($form->get('dateNaissance')->getData());
        $beneficiaire->setLieuNaissance($form->get('lieuNaissance')->getData());
        $beneficiaire->setSexe($form->get('sexe')->getData());
        $beneficiaire->setClasse($form->get('classe')->getData());
        $beneficiaire->setReligion($form->get('religion')->getData());
        $beneficiaire->setNomTuteur($form->get('nomTuteur')->getData());
        $beneficiaire->setDomicile($form->get('domicile')->getData());
        $beneficiaire->setAdresse($form->get('adresse')->getData());
        $beneficiaire->setPrefecture($form->get('prefecture')->getData());
        $beneficiaire->setRegion($form->get('region')->getData());
         $beneficiaire->setPays($form->get('pays')->getData());
        $beneficiaire->setRangOccupe($form->get('rangOccupe')->getData());
        
        $beneficiaireAge=$beneficiaire->getAgeMois($form->get('dateNaissance')->getData());
        $categories=$this->getDoctrine()
             ->getRepository(Beneficiaire::class)->attribuerCategorie($beneficiaireAge);
       foreach ($categories as $key => $value) {
            $categorie=$value;
            $beneficiaire->setCategorie($categorie);
        }       
        
        $beneficiaire->setNumero($numero);

            //$beneficiaire = $form->getData();
             $entityManager->persist($beneficiaire);
             $entityManager->flush();   
                $this->addFlash("ajoute", "Bénéficiaire ".$beneficiaire->getPrenom()." ".$beneficiaire->getNom()." a été créé(e) avec succès !");
             return $this->redirectToRoute('creerbeneficiaire');
         }

         return $this->render('admin/beneficiaire/creerbeneficiaire.html.twig', [
             'form' => $form->createView()]);
         
     }

     #[Route('/showbeneficiaire/{num}', name: 'showbeneficiaire')]
     public function show($num): Response
     {
         $benef = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findOneBy(["id"=>$num]);
            //$benef = $this->getDoctrine()
             //->getRepository(Beneficiaire::class)->find($id);
            
         return $this->render('admin/beneficiaire/afficherbeneficiaire.html.twig', compact('benef'));
     }

     #[Route('/edit_beneficiaire/{id}', name: 'edit_beneficiaire')]
   public function edit(Request $request,$id): Response
     {
        $beneficiaires = new Beneficiaire();
        
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(BeneficiaireFormType::class, $beneficiaires);
        

       $resultat = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $beneficiaire=$value;
            }
          
        $form->get('nom')->setData($beneficiaire->getNom());
        $form->get('prenom')->setData($beneficiaire->getPrenom());
        $form->get('telephone')->setData($beneficiaire->getTelephone());
        $form->get('email')->setData($beneficiaire->getEmail());
        $form->get('dateNaissance')->setData($beneficiaire->getDateNaissance());
        $form->get('lieuNaissance')->setData($beneficiaire->getLieuNaissance());
        $form->get('sexe')->setData($beneficiaire->getSexe());
         $form->get('domicile')->setData($beneficiaire->getDomicile());
          $form->get('region')->setData($beneficiaire->getRegion());
           $form->get('prefecture')->setData($beneficiaire->getPrefecture());
            $form->get('pays')->setData($beneficiaire->getPays());
        $form->get('classe')->setData($beneficiaire->getClasse());
        $form->get('religion')->setData($beneficiaire->getReligion());
        $form->get('nomTuteur')->setData($beneficiaire->getNomTuteur());
        $form->get('adresse')->setData($beneficiaire->getAdresse());
        $form->get('rangOccupe')->setData($beneficiaire->getRangOccupe());
        

        
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

        $beneficiaire->setNom($form->get('nom')->getData())  ;
        $beneficiaire->setPrenom($form->get('prenom')->getData());
        $beneficiaire->setTelephone($form->get('telephone')->getData());
        $beneficiaire->setEmail($form->get('email')->getData());
        $beneficiaire->setDateNaissance($form->get('dateNaissance')->getData());
        $beneficiaire->setLieuNaissance($form->get('lieuNaissance')->getData());
        $beneficiaire->setSexe($form->get('sexe')->getData());
        $beneficiaire->setClasse($form->get('classe')->getData());
        $beneficiaire->setReligion($form->get('religion')->getData());
        $beneficiaire->setNomTuteur($form->get('nomTuteur')->getData());
        $beneficiaire->setDomicile($form->get('domicile')->getData());
        $beneficiaire->setAdresse($form->get('adresse')->getData());
        $beneficiaire->setPrefecture($form->get('prefecture')->getData());
        $beneficiaire->setRegion($form->get('region')->getData());
         $beneficiaire->setPays($form->get('pays')->getData());
        $beneficiaire->setRangOccupe($form->get('rangOccupe')->getData());
        

         $entityManager->persist($beneficiaire);
          $entityManager->flush();   
         $this->addFlash("modifier", "modification effectuée avec succès !");
             return $this->redirectToRoute('list_beneficiaire');

         
         }


         return $this->render('admin/beneficiaire/edit_beneficiaire.html.twig', [
             'form' => $form->createView()]);
    }

    #[Route('/delete_beneficiaire/{num}', name: 'delete_beneficiaire')]
     public function delete($num): Response
     {
         $entityManager = $this->getDoctrine()->getManager();
         $benef = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findOneBy(["id"=>$num]);
         $entityManager->remove($benef);
         $entityManager->flush();
         $this->addFlash("modifier", "opération effectuée avec succès !");
        
             return $this->redirectToRoute('list_beneficiaire');
     }

     #[Route('/download/pdf', name: 'download_pdf')]
     public function download(): Response
     {
         $pdf= new PdfService(); 

          $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findAll();
          $benef = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findOneBy(["id"=> 45]);
         $html = $this->renderView('admin/beneficiaire/afficherbeneficiaire.html.twig', compact('benef'));
         // $html = $this->render('admin/beneficiaire/afficherbeneficiaire.html.twig',[ 'beneficiaires' => $beneficiaires]);
         $html=
         $pdf->generateBinaryPdf($html);
        // $pdf->showPdfFile($html);

         return new Response('', 200, ['Content-Type' => 'application/pdf',]);

        
        
     }

 }


