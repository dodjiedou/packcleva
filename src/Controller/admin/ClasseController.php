<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Form\ClasseType;
use App\Form\AbsenceType;
use App\Form\SeanceType;
use App\Form\CoursType;
use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Seance;
use App\Entity\Absence;
use App\Entity\Beneficiaire;
use App\Entity\Categorie;
use App\Form\FullClassType;

class ClasseController extends AbstractController
{
    #[Route('/classe', name: 'classe')]
    public function index(): Response
    {
        $tabClass =[[]];
        $classes = $this->getDoctrine()
            ->getRepository(Classe::class)->findAll();
        foreach ($classes as $key => $nom) {
            $beneficiaireM=0;
            $beneficiaireF=0;
           
             //$beneficiaires=$this->getDoctrine()->getRepository(Beneficiaire::class)->findBy(['classecde'=>$nom]);
             $beneficiaires=$nom->getBeneficiaires();
             foreach ($beneficiaires as $benef => $beneficiaire) {
             
                if ($beneficiaire->getSexe()=='M' ) {
                    $beneficiaireM=$beneficiaireM+1;
                }else{
                      $beneficiaireF=$beneficiaireF+1;
                }
                
               
             }
             $tabClass[$key][0]=$nom->getNom();
             $tabClass[$key][1]=$nom->getCategorie()->getNom();
             $tabClass[$key][2]=$beneficiaireF;
             $tabClass[$key][3]=$beneficiaireM;
             $tabClass[$key][4]=($beneficiaireF+$beneficiaireM);
             $tabClass[$key][5]=$nom->getId();
             $tabClass[$key][6]=$nom->getAnnee();
              
 
         }
        return $this->render('admin/classe/liste_classe.html.twig',compact('tabClass'));
    }

    #[Route('/addclass', name: 'addclass')]
    public function ajouterClasse(Request $request): Response
    {
        $classe = new Classe();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ClasseType::class, $classe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $classe = $form->getData();
            $entityManager->persist($classe);
            $entityManager->flush();
            return $this->redirectToRoute('addclass');
        }
       
        return $this->render('admin/classe/addClasse.html.twig',[
            'form' => $form->createView()]);
    }



    
    #[Route('/editclass/{id}', name: 'editclass')]
    public function ModifierClasse(Request $request,$id): Response
    {
        $classes = new Classe();
        
         $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createForm(ClasseType::class, $classes);
        

       $resultat = $this->getDoctrine()
             ->getRepository(Classe::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $classe=$value;
            }
          
        $form->get('nom')->setData($classe->getNom());
        $form->get('categorie')->setData($classe->getCategorie());
        $form->get('annee')->setData($classe->getAnnee());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $classe->setNom($form->get('nom')->getData())  ;
        $classe->setCategorie($form->get('categorie')->getData());
        $classe->setAnnee($form->get('annee')->getData());
        
         $entityManager->persist($classe);
          $entityManager->flush();   
         $this->addFlash("modifierclasse", "modification effectuée avec succès !");
             return $this->redirectToRoute('classe');

         
         }

 
        return $this->render('admin/classe/edit_classe.html.twig',[
            'form' => $form->createView()]);
 

    }


    #[Route('/showclass/{id}', name: 'showclass')]
    public function afficherClasse(Request $request,$id): Response
    {

      $classe = $this->getDoctrine()->getRepository(Classe::class)->findById($id);
       foreach ($classe as $key => $value) {

           $classe1=$value;
       }

       $beneficiaires = $classe1->getBeneficiaires();
      
        $form = $this->createForm(FullClassType::class);
        
        $entityManager = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $agemin = $form->get("agemin")->getData();
            $agemax = $form->get("agemax")->getData();
            $effectif = $form->get("effectif")->getData();
           
            $benef = $this->getDoctrine()
            ->getRepository(Beneficiaire::class)->findByAge($agemin,$agemax,$effectif,$classe1);
            foreach ($benef as $key => $value) {
               $classe1->addBeneficiaire($value);
            }
            
           
             return $this->render('admin/classe/showclasse.html.twig',[
               // 'form' => $form->createView(), 
               'beneficiaires' => $beneficiaires,
                'classe1'=>$classe1,]);
            
        }
            
            
        return $this->render('admin/classe/showclasse.html.twig',[
                //'form' => $form->createView(), 
               'beneficiaires' => $beneficiaires,
                'classe1'=>$classe1,]);
    
    }



    #[Route('/deleteclass/{id}', name: 'deleteclass')]
    public function supprimerClasse($id): Response
    {
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Classe::class)->findById($id);
       foreach ($result as $key => $value) {

           $classe=$value;
       }
         $entityManager->remove($classe);
         $entityManager->flush();
         $this->addFlash("modifierclasse", "opération effectuée avec succès !");
        
             return $this->redirectToRoute('classe');
    }



    #[Route('/remplir/{id}', name: 'remplir')]
    public function remplir(Request $request,$id): Response
    {
       // $classe = new Classe();
        $tabBeneficiaires =[];
       $result = $this->getDoctrine()
             ->getRepository(Classe::class)->findById($id);
       foreach ($result as $key => $value) {

           $classe=$value;
       }
        $entityManager = $this->getDoctrine()->getManager();

       $form = $this->createFormBuilder()
        
        ->add('nombreDeBeneficiaire',IntegerType::class, [
                'label' => "Nombre de Bénéficiaire",
                'required'=> true,
                ])
        
           
        ->add('save', SubmitType::class, ['label' => 'Enregistrer','attr'=>['class'=>'btn btn-primary w-100']])
        
        ->getForm();
                

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            

           $nombreBeneficiaire=$form->get('nombreDeBeneficiaire')->getData();
            $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findBy(['categorie'=>$classe->getCategorie()]);
           foreach ($beneficiaires as $key => $value) {
            
               $beneficiaire=$value;
               if ($beneficiaire->getClassecde()==null){
                
                array_push($tabBeneficiaires, $beneficiaire);
                  
               }
           }

           if (count($tabBeneficiaires)<$nombreBeneficiaire) {
               $nombreBeneficiaire=count($tabBeneficiaires);
           }
           foreach ($tabBeneficiaires as $key => $value) {
            
               $benef=$value;
               if ($key<$nombreBeneficiaire) {
                
                $benef->setClassecde($classe);
                $entityManager->persist($benef);
                $entityManager->flush();
                       
               }
           }


 
            return $this->redirectToRoute('classe');
        }
       
        return $this->render('admin/classe/fullClass.html.twig',[
            'form' => $form->createView()]);
    }



    #[Route('/createseance/{id}', name: 'create_seance')]
    public function createSeance(Request $request,$id): Response
    {
        $seance = new Seance();
        $entityManager = $this->getDoctrine()->getManager();
        $result = $this->getDoctrine()
             ->getRepository(Classe::class)->findById($id);
       foreach ($result as $key => $value) {

           $classe=$value;
       }

        $form = $this->createForm(SeanceType::class, $seance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $seance->setDateSeance($form->get('dateSeance')->getData())  ;
            $seance->setHeureDebutSeance($form->get('heureDebutSeance')->getData());
            $seance->setHeureFinSeance($form->get('heureFinSeance')->getData());
            $seance->setActivite($form->get('activite')->getData());
            $seance->setClasse($classe);
            $entityManager->persist($seance);
            $entityManager->flush();
            $this->addFlash("modifierclasse", "opération effectuée avec succès !");
            return $this->redirectToRoute('classe');
        }
       
        return $this->render('admin/classe/create_seance.html.twig',[
            'form' => $form->createView()]);
    }



     #[Route('/liste/absence', name: 'liste_absence')]
    public function listeAbsence(): Response
    {
       $tabAbsence=[[]];
     
       $seance = $this->getDoctrine()->getRepository(Classe::class)->findLastSeance();
        $beneficiaires= $seance->getClasse()->getBeneficiaires();
        foreach ($beneficiaires as $key => $value) {
           $beneficiaire=$value;
            $absent=0;
           $absence=$this->getDoctrine()->getRepository(Classe::class)->findAbsence($seance,$beneficiaire);
           if ($absence!= null) {
               $absent=1;
           }

            
             $tabAbsence[$key][1]=$beneficiaire->getNumero();
             $tabAbsence[$key][2]=$beneficiaire->getNom();
             $tabAbsence[$key][3]=$beneficiaire->getPrenom();
             $tabAbsence[$key][4]=$absent;
              $tabAbsence[$key][5]=$beneficiaire->getId();
              
        }

       
        return $this->render('admin/classe/liste_absence.html.twig',[
            'seance' =>$seance,
            'tabAbsence' =>$tabAbsence,
        ]);
    }

     #[Route('/affecterabsence/{ids}/{idb}', name: 'affecter_absence')]
    public function affecterAbsence(Request $request,$ids,$idb): Response
    {
        


        $absence = new Absence();
        $entityManager = $this->getDoctrine()->getManager();
        
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findById($idb);

       foreach ($beneficiaires as $key => $value) {

           $beneficiaire=$value;
           
        }
       $seances = $this->getDoctrine()->getRepository(Seance::class)->findById($ids);
        foreach ($seances as $key => $value) {
           $seance=$value;
        }
   

        $form = $this->createForm(AbsenceType::class, $absence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $absence->setAbsent($form->get('absent')->getData())  ;
            $absence->setCommentaire($form->get('commentaire')->getData());
            $absence->setBeneficiaire($beneficiaire);
            $absence->setSeance($seance);
            $entityManager->persist($absence);
            $entityManager->flush();
            return $this->redirectToRoute('liste_absence');
        }     

       
        return $this->render('admin/classe/affecter_absence.html.twig',[
             'form' => $form->createView()
        ]);
    }










}
