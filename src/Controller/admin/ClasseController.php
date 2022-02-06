<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ClasseType;
use App\Form\CoursType;
use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Beneficiaire;
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
}
