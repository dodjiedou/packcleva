<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\CadeauLocalite;
use App\Form\CadeauLocaliteType;
use App\Entity\CadeauRangOccupe;
use App\Form\CadeauRangOccupeType;
use App\Entity\CadeauAge;
use App\Form\CadeauAgeType;
use App\Entity\CadeauClasseCde;
use App\Form\CadeauClasseCdeType;
use App\Entity\CadeauNiveauEtude;
use App\Form\CadeauNiveauEtudeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */

class CadeauController extends AbstractController
{

    #[Route('/cadeau/localite', name: 'cadeau_localite')]
     public function new(Request $request): Response
     {
        $cadeauLocalite = new CadeauLocalite();
       
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(CadeauLocaliteType::class, $cadeauLocalite);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $cadeauLocalite = $form->getData();
             $entityManager->persist($cadeauLocalite);
             $entityManager->flush();   
               $this->addFlash("ajoutecadeau", "Enregistrement éffectué avec succès !");
             return $this->redirectToRoute('cadeau_localite');
         }

         return $this->render('admin/cadeau/create_cadeau.html.twig', [
             'form' => $form->createView()]);
         
     }


    #[Route('/cadeau/rang', name: 'cadeau_rang')]
     public function newrang(Request $request): Response
     {
        $cadeaurangoccupe = new CadeauRangOccupe();
       
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(CadeauRangOccupeType::class, $cadeaurangoccupe);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $cadeaurangoccupe = $form->getData();
             $entityManager->persist($cadeaurangoccupe);
             $entityManager->flush();   
                $this->addFlash("ajoutecadeau", "Enregistrement éffectué avec succès !");
             return $this->redirectToRoute('cadeau_rang');
         }

         return $this->render('admin/cadeau/create_cadeau.html.twig', [
             'form' => $form->createView()]);
         
     }


    #[Route('/cadeau/age', name: 'cadeau_age')]
     public function newage(Request $request): Response
     {
        $cadeauage = new CadeauAge();
       
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(CadeauAgeType::class, $cadeauage);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $cadeauage = $form->getData();
             $entityManager->persist($cadeauage);
             $entityManager->flush();   
               $this->addFlash("ajoutecadeau", "Enregistrement éffectué avec succès !");
             return $this->redirectToRoute('cadeau_age');
         }

         return $this->render('admin/cadeau/create_cadeau.html.twig', [
             'form' => $form->createView()]);
         
     }


    #[Route('/cadeau/classe/cde', name: 'cadeau_classecde')]
     public function newcde(Request $request): Response
     {
        $cadeauclassecde = new CadeauClasseCde();
       
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(CadeauClasseCdeType::class, $cadeauclassecde);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $cadeauclassecde->setNomArticle($form->get('nomArticle')->getData());
            $cadeauclassecde->setMesureArticle($form->get('mesureArticle')->getData());
            $cadeauclassecde->setNombreFille($form->get('nombreFille')->getData());
            $cadeauclassecde->setNombreGarcon($form->get('nombreGarcon')->getData());
            $cadeauclassecde->setNomClasse($form->get('nomClasse')->getData());
            
             $entityManager->persist($cadeauclassecde);
             $entityManager->flush();   
                $this->addFlash("ajoutecadeau", "Enregistrement éffectué avec succès !");
             return $this->redirectToRoute('cadeau_classecde');
         }

         return $this->render('admin/cadeau/create_cadeau.html.twig', [
             'form' => $form->createView()]);
         
     }


    #[Route('/cadeau/niveau/etude', name: 'cadeau_niveauetude')]
     public function newniveau(Request $request): Response
     {
        $cadeauniveauetude = new CadeauNiveauEtude();
       
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(CadeauNiveauEtudeType::class, $cadeauniveauetude);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $cadeauniveauetude = $form->getData();
             $entityManager->persist($cadeauniveauetude);
             $entityManager->flush();   
               $this->addFlash("ajoutecadeau", "Enregistrement éffectué avec succès !");
             return $this->redirectToRoute('cadeau_niveauetude');
         }

         return $this->render('admin/cadeau/create_cadeau.html.twig', [
             'form' => $form->createView()]);
         
     }

     #[Route('/critere', name: 'critere')]
    public function critere(Request $request): Response
    {


        $form = $this->createFormBuilder()
             ->add('type',ChoiceType::class, [
            'label' => "Veuiller choisir le critère de distribution ",
             'choices'  => [
             'Rang occupé' => 'rang',
             "Niveau d'étude" => 'niveau',
             'Age' => 'age',
             'Localité' => 'localite',
             'Classe au CDE' => 'classe',
              ]])
            
            ->add('save', SubmitType::class, ['label' => 'Valider','attr' => ['class' => 'btn-info w-100']])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $type = $form->get('type')->getData();

             switch($type){
                case "rang":
                    return $this->redirectToRoute('cadeau_rang');
                    break;
                case "niveau":
                   return $this->redirectToRoute('cadeau_niveauetude');
                    break;
                case "age":
                    return $this->redirectToRoute('cadeau_age');
                    break;
                case "localite":
                    return $this->redirectToRoute('cadeau_localite');
                    break;
                
                default:
                return $this->redirectToRoute('cadeau_classecde');;
                   
            }
             
             
         }

        return $this->render('admin/cadeau/choix_critere.html.twig', [
            'form' =>$form->createView() ]);
    }

     #[Route('/cadeau/statistique', name: 'cadeau_statistique')]
     public function statistique(Request $request): Response
     {
        $form = $this->createFormBuilder()
             ->add('type',ChoiceType::class, [
            'label' => "Veuiller choisir un critère  ",
             'choices'  => [
             'Rang occupé' => 'rang',
             "Niveau d'étude" => 'niveau',
             'Age' => 'age',
             'Localité' => 'localite',
             'Classe au CDE' => 'classe',
              ]])
            
            ->add('save', SubmitType::class, ['label' => 'Valider','attr' => ['class' => 'btn-info w-100']])
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $type = $form->get('type')->getData();

             switch($type){
                case "rang":
                    return $this->redirectToRoute('cadeau_statistique1');
                    break;
                case "niveau":
                   return $this->redirectToRoute('cadeau_statistique3');
                    break;
                case "age":
                    return $this->redirectToRoute('cadeau_statistique2');
                    break;
                case "localite":
                    return $this->redirectToRoute('cadeau_statistique5');
                    break;
                
                default:
                return $this->redirectToRoute('cadeau_statistique4');;
                   
            }
        }
         return $this->render('admin/cadeau/statistique.html.twig', [
            'form' =>$form->createView() ]);
             

         
     }

    #[Route('/cadeau/statistique1', name: 'cadeau_statistique1')]
     public function statistique1(): Response
     {
       
       $cadeaurangoccupes=new CadeauRangOccupe();
       $cadeaurangoccupes = $this->getDoctrine()
             ->getRepository(CadeauRangOccupe::class)->findAll();

         return $this->render('admin/cadeau/rang_occupe.html.twig',[
             'cadeaurangoccupes' => $cadeaurangoccupes,
         ]);
             
     }
    
      #[Route('/cadeau/statistique2', name: 'cadeau_statistique2')]
     public function statistique2(): Response
     {
       
        $cadeauages= new CadeauClasseCde();
        

        $cadeauages = $this->getDoctrine()
             ->getRepository(CadeauAge::class)->findAll();
     

         return $this->render('admin/cadeau/age.html.twig',[
             'cadeauages' => $cadeauages,
             
         ]);
         
     }

     #[Route('/cadeau/statistique3', name: 'cadeau_statistique3')]
     public function statistique3(): Response
     {
       
        $cadeauniveauetudes=new CadeauNiveauEtude();
        $cadeauniveauetudes = $this->getDoctrine()
             ->getRepository(CadeauNiveauEtude::class)->findAll(); 

         return $this->render('admin/cadeau/niveau_etude.html.twig',[
             'cadeauniveauetudes' => $cadeauniveauetudes,
         ]);
             
     }

      #[Route('/cadeau/statistique4', name: 'cadeau_statistique4')]
     public function statistique4(): Response
     {
       
        $cadeauclassecdes=new CadeauClasseCde();
        $cadeauclassecdes = $this->getDoctrine()
             ->getRepository(CadeauClasseCde::class)->findAll();

         return $this->render('admin/cadeau/classe_cde.html.twig',[
             'cadeauclassecdes' => $cadeauclassecdes,
         ]);
             
     }
     #[Route('/cadeau/statistique5', name: 'cadeau_statistique5')]
     public function statistique5(): Response
     {
       
        $cadeaulocalites=new CadeauLocalite();
        $cadeaulocalites = $this->getDoctrine()
             ->getRepository(CadeauLocalite::class)->findAll();

         return $this->render('admin/cadeau/localite.html.twig',[
             'cadeaulocalites' => $cadeaulocalites,
         ]);
             
     }





    
   
}
