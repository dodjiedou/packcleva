<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;
use App\Entity\Culculum;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CulculumController extends AbstractController
{
    #[Route('/culculum', name: 'culculum')]
    public function index(Request $request): Response
    {


        $form = $this->createFormBuilder()
             ->add('categorie', EntityType::class, [
                'class' => Categorie ::class,
                'choice_label' => 'nom',
                'label' => ' ',
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Valider','attr' => ['class' => 'btn-primary w-100']])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $form->get('categorie')->getData();
             
             return $this->redirectToRoute('culculum_create',["nom"=>$categorie->getNom()]);
         }

        return $this->render('admin/culculum/index.html.twig', [
            'form' =>$form->createView() ]);
    }

    #[Route('/culculum/{nom}', name: 'culculum_create')]
    public function create(Request $request,$nom): Response
    {


       $entityManager = $this->getDoctrine()->getManager();

       $categorie = $this->getDoctrine()
             ->getRepository(Categorie::class)->findOneBy(["nom"=>$nom]);

       $culculum =new Culculum();

        $form = $this->createFormBuilder()
             ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
             ->add('numerolecon',TextType::class,[ 'label' => 'Numero de la leçon'])
            ->add('titrelecon',TextType::class,[ 'label' => 'Titre de la leçon'])
            
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $culculum->setDate($form->get('date')->getData());

            $culculum->setNumeroLecon($form->get('numerolecon')->getData());

            $culculum->setTitreLecon($form->get('titrelecon')->getData());

            $culculum->setCategorie($categorie);
            
             $entityManager->persist($culculum);
            $entityManager->flush();
             $this->addFlash("ajoute", "Activité enrégistrée avec succès !");
             return $this->redirectToRoute('culculum_create',["nom"=>$categorie->getNom()]);
         
         }

        return $this->render('admin/culculum/create_culculum.html.twig', [
            'form' =>$form->createView() ]);
    }

    #[Route('/show/culculum', name: 'show_culculum')]
     public function list(Request $request): Response
     {
        $culculums = $this->getDoctrine()
             ->getRepository(Culculum::class)->findAll();

             $form = $this->createFormBuilder()
             ->add('categorie', EntityType::class, [
                'class' => Categorie ::class,
                'choice_label' => 'nom',
                'label' => 'Categorie ',
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();
           $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $form->get("categorie")->getData();
           
            $culculums = $this->getDoctrine()
            ->getRepository(Culculum::class)->findBy(["categorie"=>$categorie]);
            return $this->render('admin/culculum/show_culculum.html.twig',[
             'culculums' => $culculums,'form' =>$form->createView()]);
           
        }
        
         return $this->render('admin/culculum/show_culculum.html.twig',[
             'culculums' => $culculums,'form' =>$form->createView()]);

         
        
     }

     #[Route('/modifier/{id}', name: 'culculum_edit')]
    public function edit(Request $request,$id): Response
    {


       $entityManager = $this->getDoctrine()->getManager();

       $culc = $this->getDoctrine()
             ->getRepository(Culculum::class)->findById($id);
       foreach ($culc as $key => $value) {

                 $culculum=$value;
        }


        $form = $this->createFormBuilder()
             ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime',
                'data'=>$culculum->getDate()
            ])
             ->add('numerolecon',TextType::class,[ 'label' => 'Numero de la leçon',
                 'data'=>$culculum->getNumeroLecon()
         ])
            ->add('titrelecon',TextType::class,[ 'label' => 'Titre de la leçon',
               'data'=>$culculum->getTitreLecon()
        ])
             ->add('categorie', EntityType::class, [
                'class' => Categorie ::class,
                'choice_label' => 'nom',
                'label' => 'Categorie ',
                 'data'=>$culculum->getCategorie()
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Modifier',
                'attr' => ['class' => 'btn-success w-100']
             ])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $culculum->setDate($form->get('date')->getData());

            $culculum->setNumeroLecon($form->get('numerolecon')->getData());

            $culculum->setTitreLecon($form->get('titrelecon')->getData());

            $culculum->setCategorie($form->get('categorie')->getData());
            
             $entityManager->persist($culculum);
            $entityManager->flush();
             $this->addFlash("modifier", "Activité modifiée avec succès !");
             return $this->redirectToRoute('show_culculum');
         
         }

        return $this->render('admin/culculum/edit_culculum.html.twig', [
            'form' =>$form->createView() ]);
    }

    #[Route('/changer/{id}', name: 'culculum_change')]
    public function change(Request $request,$id): Response
    {


       $entityManager = $this->getDoctrine()->getManager();

       $culc = $this->getDoctrine()
             ->getRepository(Culculum::class)->findById($id);
       foreach ($culc as $key => $value) {

                 $culculum=$value;
        }

        $titre=$culculum->getTitreLecon();

        $numero=$culculum->getNumeroLecon();

        $culculums  = $this->getDoctrine()
             ->getRepository(Culculum::class)->findByCategorie($culculum);


        $form = $this->createFormBuilder()
             ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime',
                'disabled'=>true,
                'data'=>$culculum->getDate()
            ])
             ->add('numerolecon',TextType::class,[ 'label' => 'Numero de la leçon',
                 'data'=>$culculum->getNumeroLecon()
         ])
            ->add('titrelecon',TextType::class,[ 'label' => 'Titre de la leçon',
               'data'=>$culculum->getTitreLecon()
        ])
             ->add('categorie', EntityType::class, [
                'class' => Categorie ::class,
                'choice_label' => 'nom',
                'label' => 'Categorie ',
                'disabled'=>true,
                 'data'=>$culculum->getCategorie()
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Changer',
                'attr' => ['class' => 'btn-info w-100']
             ])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
               
           $culculum->setNumeroLecon($form->get('numerolecon')->getData());

            $culculum->setTitreLecon($form->get('titrelecon')->getData());
             $entityManager->persist($culculum);
            $entityManager->flush(); 
            foreach ($culculums as $key => $value) {
               $numero2 = $value->getNumeroLecon();
                $titre2 = $value->getTitreLecon();
                $value->setNumeroLecon($numero);
                $value->setTitreLecon($titre);
             $entityManager->persist($value);
             $entityManager->flush();
              $titre=$titre2;
              $numero=$numero2;

                
            }

             $this->addFlash("modifier", "Activité changée avec succès !");
             return $this->redirectToRoute('show_culculum');
         
         }

        return $this->render('admin/culculum/edit_culculum.html.twig', [
            'form' =>$form->createView() ]);
    }

    #[Route('/delete/{id}', name: 'culculum_delete')]
     public function delete($id): Response
     {
         $entityManager = $this->getDoctrine()->getManager();
       $culc = $this->getDoctrine()
             ->getRepository(Culculum::class)->findById($id);
       foreach ($culc as $key => $value) {

                 $culculum=$value;
        }

         $entityManager->remove($culculum);
         $entityManager->flush();
         $this->addFlash("modifier", "Suppression éffectuée avec succès !");
             return $this->redirectToRoute('show_culculum');
     }


}
