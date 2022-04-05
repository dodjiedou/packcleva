<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Visite;
use App\Entity\CategorieVisite;
use App\Entity\Suivi;
use App\Entity\Beneficiaire;
use App\Form\VisiteType;
use App\Form\CategorieVisiteType;
use App\Form\SuiviType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */


class VisiteController extends AbstractController
{
    

     #[Route('/categorie/visite', name: 'categorie_visite')]
     public function newCategorie(Request $request): Response
     {
        $categorieVisite = new CategorieVisite();
        
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(CategorieVisiteType::class, $categorieVisite);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $categorieVisite = $form->getData();
             $entityManager->persist($categorieVisite);
             $entityManager->flush();   
             return $this->redirectToRoute('categorie_visite');
         }

         return $this->render('admin/visite/create_categorie_visite.html.twig', [
             'form' => $form->createView()]);
         
     }

      #[Route('/create/visite', name: 'create_visite')]
     public function newVisite(Request $request): Response
     {
        $visite = new Visite();
        
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(VisiteType::class, $visite);

          
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {


            $visite = $form->getData();
             $entityManager->persist($visite);
             $entityManager->flush();   
             return $this->redirectToRoute('create_visite');
         }

         return $this->render('admin/visite/create_visite.html.twig', [
             'form' => $form->createView()]);

     }


     

      #[Route('/create/suivi/{id}', name: 'create_suivi')]
     public function newSuivi(Request $request,$id): Response
     {
        $suivi = new Suivi();
        
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(SuiviType::class, $suivi);
         $resultat = $this->getDoctrine()
             ->getRepository(Visite::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $visite=$value;
            }

        $beneficiaireId=$visite->getBeneficiaire()->getId();

        $form->get('visite')->setData($visite);


         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $suivi->setObservation($form->get('observation')->getData());
            $suivi->setDateDebut($form->get('dateDebut')->getData());
             $suivi->setDateFin($form->get('dateFin')->getData());
             $suivi->setRapport($form->get('rapport')->getData());
             $suivi->setVisite($form->get('visite')->getData());
           
             $entityManager->persist($suivi);
             $entityManager->flush();   
             return $this->redirectToRoute('create_suivi',['id'=>$id]);
         }

         return $this->render('admin/visite/create_suivi.html.twig', [
            'beneficiaireId'=>$beneficiaireId,
             'form' => $form->createView()]);
         
     }


    #[Route('/liste/beneficiaire/visite', name: 'liste_beneficiaire_visite')]
     public function lister(): Response
     {
          
      $tabBeneficiaires =[];
       $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
       foreach ($beneficiaires as $key => $beneficiaire) {

        $visite = $this->getDoctrine()
             ->getRepository(Visite::class)->findOneBy(['beneficiaire'=>$beneficiaire]);

            if ($visite != null) {

               array_push($tabBeneficiaires, $beneficiaire);

            }
           
       }
        
       
         return $this->render('admin/visite/liste_beneficiaire_visite.html.twig',[
             'beneficiaires' => $tabBeneficiaires]);
        
     }

      #[Route('/mes/visites/{id}', name: 'mes_visites')]
   public function mesvisites(Request $request,$id): Response
     {

      $beneficiaire = $this->getDoctrine()->getRepository(Beneficiaire::class)->findById($id);
        foreach ($beneficiaire as $key => $value) {
           $benef=$value;
        }

        $visites = $benef->getVisites();
       
          return $this->render('admin/visite/mes_visites.html.twig',[
             'visites' => $visites]);
    }

    #[Route('/ajouter/visite/{id}', name: 'ajouter_visite')]
    public function ajouterVisite(Request $request,$id): Response
    {
        $visite= new Visite();
       
        $entityManager = $this->getDoctrine()->getManager();
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findById($id);
        foreach ($beneficiaires as $key => $value) {
           $beneficiaire=$value;
        }

        $form = $this->createFormBuilder()
             ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('description',TextareaType::class, [
                'label' => "Description",
                'required'=> false,
                ])
             ->add('beneficiaire',EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Beneficiaire',
                'required'=> true,
                'disabled'=> true,
                
            ])
            ->add('categorieVisite',EntityType::class, [
                'class' => CategorieVisite ::class,
                'choice_label' => 'nom',
                'label' => 'Categorie',
                'required'=> true,
                
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
            ])
            

            ->getForm();

         $form->get('beneficiaire')->setData($beneficiaire);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
  
            $visite->setDate($form->get('date')->getData())  ;
            $visite->setDescription($form->get('description')->getData());
            $visite->setBeneficiaire($form->get('beneficiaire')->getData());
            $visite->setCategorieVisite($form->get('categorieVisite')->getData());
            $entityManager->persist($visite);
            $entityManager->flush();
            return $this->redirectToRoute('ajouter_visite',['id'=>$id]);
            
        }

        
       
        return $this->render('admin/visite/ajouter_visite.html.twig',[
            'form' => $form->createView()]);
    }

     #[Route('/show/suivi/{id}', name: 'show_suivi')]
     public function show_suivi($id): Response
     {
          
      $visites = $this->getDoctrine()->getRepository(Visite::class)->findById($id);
      foreach ($visites as $key => $value) {

          $visite = $value;
           
       }

      $beneficiaireId=$visite->getBeneficiaire()->getId();

      $suivi=$visite->getSuivi();
       
          return $this->render('admin/visite/show_suivi.html.twig',[
             'suivi' => $suivi,
              'beneficiaireId'=> $beneficiaireId,
               
         ]);
        
     }

     #[Route('/edit/suivi/{id}', name: 'edit_suivi')]
    public function ModifierSuivi(Request $request,$id): Response
    {
         $suivi= new Suivi();
        
         $entityManager = $this->getDoctrine()->getManager();
         $form = $this->createFormBuilder()
            ->add('observation',TextareaType::class, [
                'label' => "Observation",
                'required'=> false,
                ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de debut de suivi',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de debut de suivi',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('rapport',TextareaType::class, [
                'label' => "Rapport de suivi",
                'required'=> false,
                ])
           
            ->add('visite',EntityType::class, [
                'class' => Visite ::class,
                'choice_label' => 'description',
                'label' => 'Visite concernée',
                'required'=> true,
                'disabled'=> true,
                
                 ])
            ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
                  ])
            
            ->getForm();

       $resultat = $this->getDoctrine()
             ->getRepository(suivi::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $suivi=$value;
            }

       $visiteId=$suivi->getVisite()->getId();
          
        $form->get('observation')->setData($suivi->getObservation());
        $form->get('dateDebut')->setData($suivi->getDateDebut());
        $form->get('dateFin')->setData($suivi->getDateFin());
        $form->get('rapport')->setData($suivi->getRapport());
        $form->get('visite')->setData($suivi->getVisite());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $suivi->setObservation($form->get('observation')->getData())  ;
        $suivi->setDateDebut($form->get('dateDebut')->getData());
        $suivi->setDateFin($form->get('dateFin')->getData());
        $suivi->setRapport($form->get('rapport')->getData());
        $suivi->setVisite($form->get('visite')->getData());



         $entityManager->persist($suivi);
          $entityManager->flush();   
         $this->addFlash("modifiersuivi", "modification effectuée avec succès !");
             return $this->redirectToRoute('show_suivi',['id'=>$visiteId]);

         
         }

 
        return $this->render('admin/visite/edit_suivi.html.twig',[
            'form' => $form->createView(),
            'visiteId'=>$visiteId
        ]);
 

    }


    



    #[Route('/delete/suivi/{id}', name: 'delete_suivi')]
    public function supprimerSuivi($id): Response
    {
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(suivi::class)->findById($id);
       foreach ($result as $key => $value) {

           $suivi=$value;
       }
        
         $visiteId=$suivi->getVisite()->getId();

         $entityManager->remove($suivi);
         $entityManager->flush();

        $this->addFlash("modifiersuivi", "modification effectuée avec succès !");
             return $this->redirectToRoute('show_suivi',['id'=>$visiteId]);
         
          

    }


    #[Route('/edit/visite/{id}', name: 'edit_visite')]
    public function ModifierVisite(Request $request,$id): Response
    {
        $visite= new Visite();
       
        $entityManager = $this->getDoctrine()->getManager();
        $visites = $this->getDoctrine()
             ->getRepository(Visite::class)->findById($id);
        foreach ($visites as $key => $value) {
           $visite=$value;
        }

         $form = $this->createFormBuilder()
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('description',TextareaType::class, [
                'label' => "Description",
                'required'=> false,
                ])
             ->add('beneficiaire',EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Beneficiaire',
                'required'=> true,
                'disabled'=> true,
                
            ])
            ->add('categorieVisite',EntityType::class, [
                'class' => CategorieVisite ::class,
                'choice_label' => 'nom',
                'label' => 'Categorie',
                'required'=> true,
                
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
            ])
            
            ->getForm();

       
      $beneficiaireId=$visite->getBeneficiaire()->getId();
          
        $form->get('date')->setData($visite->getDate());
        $form->get('description')->setData($visite->getDescription());
        $form->get('beneficiaire')->setData($visite->getBeneficiaire());
        $form->get('categorieVisite')->setData($visite->getCategorieVisite());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        
        $visite->setDate($form->get('date')->getData())  ;
            $visite->setDescription($form->get('description')->getData());
            $visite->setBeneficiaire($form->get('beneficiaire')->getData());
            $visite->setCategorieVisite($form->get('categorieVisite')->getData());
            $entityManager->persist($visite);
            $entityManager->flush();
            $this->addFlash("modifiervisite", "modification effectuée avec succès !");
             return $this->redirectToRoute('mes_visites',['id'=>$beneficiaireId]);

         
         }
         
        return $this->render('admin/visite/edit_visite.html.twig',[
            'form' => $form->createView(),
            'beneficiaireId'=>$beneficiaireId
        ]);
 

    }


    



    #[Route('/delete/visite/{id}', name: 'delete_visite')]
    public function supprimerVisite($id): Response
    {
      $visite= new Visite();
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Visite::class)->findById($id);
       foreach ($result as $key => $value) {

           $visite=$value;
       }
       $beneficiaireId=$visite->getBeneficiaire()->getId();
         $entityManager->remove($visite);
         $entityManager->flush();
         $this->addFlash("modifiervisite", "opération effectuée avec succès !");
              return $this->redirectToRoute('mes_visites',['id'=>$beneficiaireId]);

    }
     




}
