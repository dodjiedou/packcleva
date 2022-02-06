<?php

namespace App\Controller\admin;

use App\Entity\Personne;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\Form;
use App\Form\BeneficiaireFormType;
use App\Repository\BeneficiaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class BeneficiaireController extends AbstractController
 {

     /*
         /list_beneficiaire
         /creerbeneficiaire
        /showbeneficiaire/{num}
         /edit_beneficiaire
        /delete_beneficiaire/{num}
     */
   

     #[Route('/list_beneficiaire', name: 'list_beneficiaire')]
     public function list(): Response
     {
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findAll();
         return $this->render('admin/beneficiaire/list_beneficiaire.html.twig',[
             'beneficiaires' => $beneficiaires]);
        
     }

     #[Route('/creerbeneficiaire', name: 'creerbeneficiaire')]
     public function new(Request $request): Response
     {
        $beneficiaire = new Beneficiaire();
         $personne = new Personne();
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $beneficiaire = $form->getData();
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
        $form->get('sexe')->setData($beneficiaire->getSexe());
        $form->get('classe')->setData($beneficiaire->getClasse());
        $form->get('religion')->setData($beneficiaire->getReligion());
        $form->get('nomTuteur')->setData($beneficiaire->getNomTuteur());
        $form->get('adresse')->setData($beneficiaire->getAdresse());
        $form->get('rangOccupe')->setData($beneficiaire->getRangOccupe());
        $form->get('classecde')->setData($beneficiaire->getClassecde());

        
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

        $beneficiaire->setNom($form->get('nom')->getData())  ;
        $beneficiaire->setPrenom($form->get('prenom')->getData());
        $beneficiaire->setTelephone($form->get('telephone')->getData());
        $beneficiaire->setEmail($form->get('email')->getData());
        $beneficiaire->setDateNaissance($form->get('dateNaissance')->getData());
        $beneficiaire->setSexe($form->get('sexe')->getData());
        $beneficiaire->setClasse($form->get('classe')->getData());
        $beneficiaire->setReligion($form->get('religion')->getData());
        $beneficiaire->setNomTuteur($form->get('nomTuteur')->getData());
        $beneficiaire->setAdresse($form->get('adresse')->getData());
        $beneficiaire->setRangOccupe($form->get('rangOccupe')->getData());
        $beneficiaire->setClassecde($form->get('classecde')->getData());

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
 }


