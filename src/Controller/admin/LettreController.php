<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Entity\Lettre;
use App\Entity\Beneficiaire;
use App\Form\LettreType;
use App\Controller\admin\BeneficiaireController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LettreController extends AbstractController
{


    #[Route('/create/lettre', name: 'create_lettre')]
    public function index(Request $request): Response
    {


        $lettre = new Lettre();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(LettreType::class, $lettre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lettre = $form->getData();
            $entityManager->persist($lettre);
            $entityManager->flush();
            return $this->redirectToRoute('create_lettre');
        }

        
       
        return $this->render('admin/lettre/create_lettre.html.twig',[
            'form' => $form->createView()]);
    }


    #[Route('/ajouter/lettre/{id}', name: 'ajouter_lettre')]
    public function ajouterLettre(Request $request,$id): Response
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findById($id);

      foreach ($beneficiaires as $key => $value) {

           $beneficiaire=$value;
           
        }
       

        $form = $this->createFormBuilder()
             ->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Beneficiaire ',
                'disabled' => true,
            ])
            ->add('correspondant',TextType::class,[ 'label' => 'Correspondant'])
            ->add('envoiReception', ChoiceType::class, [
             'label' => 'Lettre reçue ou envoyée', 
             'choices'  => [
             'Reçue' => 'Reçue',
             'Envoyée' => 'Envoyée',
                ]])
            ->add('dateExpedition', DateType::class, [
                'label' => "Date d'expédition",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('dateReception', DateType::class, [
                'label' => 'Date de reception',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])

            ->getForm();

         $form->get('beneficiaire')->setData($beneficiaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
  
            $lettre->setBeneficiaire($form->get('beneficiaire')->getData())  ;
            $lettre->setCorrespondant($form->get('correspondant')->getData());
            $lettre->setDateExpedition($form->get('dateExpedition')->getData());
            $lettre->setEnvoiReception($form->get('envoiReception')->getData());
            $lettre->setDateReception($form->get('dateReception')->getData());
                $entityManager->persist($lettre);
            $entityManager->flush();
            
        }

        
       
        return $this->render('admin/lettre/ajouter_lettre.html.twig',[
            'form' => $form->createView()]);
    }




    #[Route('/create/question/{id}', name: 'create_question')]
    public function question(Request $request,$id): Response
    {


        $question = new Question();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(QuestionType::class, $question);
        $resultat = $this->getDoctrine()
             ->getRepository(Lettre::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $lettre=$value;
            }
            

        $beneficiaire=$lettre->getBeneficiaire()->getId();
       
        $form->get('lettre')->setData($lettre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $question->setDateQuestion($form->get('dateQuestion')->getData());
        $question->setLettre($form->get('lettre')->getData());
        $question->setLibelle($form->get('libelle')->getData());

            $question = $form->getData();
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('create_question',['id'=>$id]);
        }

        
         return $this->render('admin/lettre/create_question.html.twig',[
            'form' => $form->createView(),
            'beneficiaire'=> $beneficiaire,
        ]);
       
    }

    
    #[Route('/create/reponse/{id}', name: 'create_reponse')]
    public function reponse(Request $request,$id): Response
    {


        $reponse = new Reponse();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ReponseType::class, $reponse);

        $resultat = $this->getDoctrine()
             ->getRepository(Question::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $question=$value;
            }

        $lettre=$question->getLettre()->getId();

        $form->get('question')->setData($question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $reponse->setDateReponse($form->get('dateReponse')->getData());
        $reponse->setQuestion($form->get('question')->getData());
        $reponse->setLibelle($form->get('libelle')->getData());

            
            $entityManager->persist($reponse);
            $entityManager->flush();
            return $this->redirectToRoute('create_reponse',['id'=>$id]);
        }

        return $this->render('admin/lettre/create_reponse.html.twig',[
            'form' => $form->createView(),
            'lettre'=>$lettre
        ]);
       
    }

    #[Route('/liste/lettre/beneficiaires', name: 'liste_lettre')]
     public function lister(): Response
     {
          
      $tabBeneficiaires =[];
       $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
       foreach ($beneficiaires as $key => $beneficiaire) {

        $lettre = $this->getDoctrine()
             ->getRepository(Lettre::class)->findOneBy(['beneficiaire'=>$beneficiaire]);

            if ($lettre != null) {

               array_push($tabBeneficiaires, $beneficiaire);

            }
           
       }

       
         return $this->render('admin/lettre/liste_lettre.html.twig',[
             'beneficiaires' => $tabBeneficiaires]);
        
     }


      #[Route('/meslettres/{id}', name: 'meslettres')]
   public function meslettres(Request $request,$id): Response
     {

      $beneficiaire = $this->getDoctrine()->getRepository(Beneficiaire::class)->findById($id);
        foreach ($beneficiaire as $key => $value) {
           $benef=$value;
        }

        $lettres = $benef->getLettres();
       
          return $this->render('admin/lettre/mes_lettres.html.twig',[
             'lettres' => $lettres]);
    }


  #[Route('/liste/question/{id}', name: 'liste_question')]
     public function listeQuestion($id): Response
     {
          
      $lettres = $this->getDoctrine()->getRepository(Lettre::class)->findById($id);
       foreach ($lettres as $key => $value) {

         $lettre = $value;
           
       }

        $beneficiaire=$lettre->getBeneficiaire()->getId();
       
         $questions = $lettre->getQuestions();
       
          return $this->render('admin/lettre/liste_question.html.twig',[
             'questions' => $questions,
              'beneficiaire'=> $beneficiaire,
               
         ]);
        
     }

    

  #[Route('/show/reponse/{id}', name: 'show_reponse')]
     public function show_reponse($id): Response
     {
          
      $questions = $this->getDoctrine()->getRepository(Question::class)->findById($id);
      foreach ($questions as $key => $value) {

          $question = $value;
           
       }

      $reponse=$question->getReponse();

      $lettre=$question->getLettre()->getId();
       
          return $this->render('admin/lettre/show_reponse.html.twig',[
             'lettre' => $lettre,
              'reponse'=> $reponse,
               
         ]);
        
     }

     
      #[Route('/edit/lettre/{id}', name: 'edit_lettre')]
    public function ModifierLettre(Request $request,$id): Response
    {
        $lettres = new Lettre();
        
         $entityManager = $this->getDoctrine()->getManager();

          //$form = $this->createForm(LettreType::class, $lettres);

         $form = $this->createFormBuilder()
             ->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Beneficiaire ',
                'disabled' => true,
            ])
            ->add('correspondant',TextType::class,[ 'label' => 'Correspondant'])
            ->add('envoiReception', ChoiceType::class, [
             'label' => 'Lettre reçue ou envoyée', 
             'choices'  => [
             'Reçue' => 'Reçue',
             'Envoyée' => 'Envoyée',
                ]])
            ->add('dateExpedition', DateType::class, [
                'label' => "Date d'expédition",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('dateReception', DateType::class, [
                'label' => 'Date de reception',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])

            ->getForm();

       $resultat = $this->getDoctrine()
             ->getRepository(Lettre::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $lettre=$value;
            }

      $beneficiaireId=$lettre->getBeneficiaire()->getId();
          
        $form->get('beneficiaire')->setData($lettre->getBeneficiaire());
        $form->get('correspondant')->setData($lettre->getCorrespondant());
        $form->get('dateExpedition')->setData($lettre->getDateExpedition());
        $form->get('envoiReception')->setData($lettre->getEnvoiReception());
        $form->get('dateReception')->setData($lettre->getDateReception());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $lettre->setBeneficiaire($form->get('beneficiaire')->getData())  ;
        $lettre->setCorrespondant($form->get('correspondant')->getData());
        $lettre->setDateExpedition($form->get('dateExpedition')->getData());
        $lettre->setEnvoiReception($form->get('envoiReception')->getData());
        $lettre->setDateReception($form->get('dateReception')->getData());
         
         $entityManager->persist($lettre);
          $entityManager->flush();   
         $this->addFlash("modifierlettre", "modification effectuée avec succès !");
             return $this->redirectToRoute('meslettres',['id'=>$beneficiaireId]);

         
         }

 
        return $this->render('admin/lettre/edit_lettre.html.twig',[
            'form' => $form->createView(),
            'beneficiaireId'=>$beneficiaireId
        ]);
 

    }


    



    #[Route('/delete/lettre/{id}', name: 'delete_lettre')]
    public function supprimerlettre($id): Response
    {
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Lettre::class)->findById($id);
       foreach ($result as $key => $value) {

           $lettre=$value;
       }
         $beneficiaireId=$lettre->getBeneficiaire()->getId();
         $entityManager->remove($lettre);
         $entityManager->flush();
         $this->addFlash("modifierlettre", "opération effectuée avec succès !");
        
        return $this->redirectToRoute('meslettres',['id'=>$beneficiaireId]);
    }
     

      #[Route('/edit/question/{id}', name: 'edit_question')]
    public function Modifierquestion(Request $request,$id): Response
    {
        $question = new Question();
        
         $entityManager = $this->getDoctrine()->getManager();

          //$form = $this->createForm(QuestionType::class, $question);

         $form = $this->createFormBuilder()
             ->add('dateQuestion', DateType::class, [
                'label' => "Date",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
             ->add('lettre', EntityType::class, [
                'class' => Lettre ::class,
                'choice_label' => 'Correspondant',
                'label' => 'Vruillez choisir la lettre',
                'disabled' => true, 
                
            ])
            ->add('libelle',TextareaType::class,[ 'label' => 'Vruillez saisir la question'])
            
            
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])
            ->getForm();

       $resultat = $this->getDoctrine()
             ->getRepository(Question::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $question=$value;
            }

      $lettreId=$question->getLettre()->getId();
          
        $form->get('dateQuestion')->setData($question->getDateQuestion());
        $form->get('lettre')->setData($question->getLettre());
        $form->get('libelle')->setData($question->getLibelle());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $question->setDateQuestion($form->get('dateQuestion')->getData())  ;
        $question->setLettre($form->get('lettre')->getData());
        $question->setlibelle($form->get('libelle')->getData());

         $entityManager->persist($question);
          $entityManager->flush();   
         $this->addFlash("modifierquestion", "modification effectuée avec succès !");
             return $this->redirectToRoute('liste_question',['id'=>$lettreId]);

         
         }

 
        return $this->render('admin/lettre/edit_question.html.twig',[
            'form' => $form->createView(),
            'lettreId'=>$lettreId
        ]);
 

    }


    



    #[Route('/delete/question/{id}', name: 'delete_question')]
    public function supprimerquestion($id): Response
    {
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Question::class)->findById($id);
       foreach ($result as $key => $value) {

           $question=$value;
       }
        $lettreId=$question->getLettre()->getId();
         $entityManager->remove($question);
         $entityManager->flush();
         $this->addFlash("modifierquestion", "opération effectuée avec succès !");
             return $this->redirectToRoute('liste_question',['id'=>$lettreId]);

    }
     


      #[Route('/edit/reponse/{id}', name: 'edit_reponse')]
    public function ModifierReponse(Request $request,$id): Response
    {
        
        
         $entityManager = $this->getDoctrine()->getManager();


         $form = $this->createFormBuilder()
             ->add('dateReponse', DateType::class, [
                'label' => "Date",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
           ->add('question', EntityType::class, [
                'class' => Question ::class,
                'choice_label' => 'libelle',
                'label' => 'Veuiler choisir la question',
                'disabled' => true,
                
            ])
            ->add('libelle',TextareaType::class,[ 'label' => 'Vruillez saisir la reponse'])
           
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])
            ->getForm();

       $resultat = $this->getDoctrine()
             ->getRepository(Reponse::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $reponse=$value;
            }

      $questionId=$reponse->getQuestion()->getId();
          
        $form->get('dateReponse')->setData($reponse->getDateReponse());
        $form->get('question')->setData($reponse->getQuestion());
        $form->get('libelle')->setData($reponse->getLibelle());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $reponse->setDateReponse($form->get('dateReponse')->getData())  ;
        $reponse->setQuestion($form->get('question')->getData());
        $reponse->setlibelle($form->get('libelle')->getData());

         $entityManager->persist($reponse);
          $entityManager->flush();   
         $this->addFlash("modifierreponse", "modification effectuée avec succès !");
             return $this->redirectToRoute('show_reponse',['id'=>$questionId]);

         
         }

 
        return $this->render('admin/lettre/edit_reponse.html.twig',[
            'form' => $form->createView(),
            'questionId'=>$questionId
        ]);
 

    }


    



    #[Route('/delete/reponse/{id}', name: 'delete_reponse')]
    public function supprimerReponse($id): Response
    {
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Reponse::class)->findById($id);
       foreach ($result as $key => $value) {

           $reponse=$value;
       }
        
         $questionId=$reponse->getQuestion()->getId();

         $entityManager->remove($reponse);
         $entityManager->flush();

        $this->addFlash("modifierreponse", "modification effectuée avec succès !");
             return $this->redirectToRoute('show_reponse',['id'=>$questionId]);
         
         

    }


    #[Route('/sommaire', name: 'sommaire')]
    public function sommaire($id): Response
    {
     
         $entityManager = $this->getDoctrine()->getManager();
         $result = $this->getDoctrine()
             ->getRepository(Reponse::class)->findById($id);
       foreach ($result as $key => $value) {

           $reponse=$value;
       }
        
         $questionId=$reponse->getQuestion()->getId();

         $entityManager->remove($reponse);
         $entityManager->flush();

        $this->addFlash("modifierreponse", "modification effectuée avec succès !");
             return $this->redirectToRoute('show_reponse',['id'=>$questionId]);
         
         

    }
    
     


}
