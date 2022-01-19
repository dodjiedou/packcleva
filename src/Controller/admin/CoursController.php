<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CoursType;
use App\Entity\Cours;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'cours')]
    public function index(): Response
    {
        return $this->render('admin/cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/addcours', name: 'addcours')]
    public function ajouterCours(Request $request): Response
    {
        $cours = new Cours();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cours = $form->getData();
            $entityManager->persist($cours);
            $entityManager->flush();
            return $this->redirectToRoute('addcours');
        }
       
        return $this->render('admin/cours/addCours.html.twig',[
            'form' => $form->createView()]);
        
    }

     #[Route('/list_cours', name: 'list_cours')]
     public function list(): Response
     {
        $cours = $this->getDoctrine()
             ->getRepository(Cours::class)->findAll();
         return $this->render('admin/cours/liste_cours.html.twig',[
             'cours' => $cours]);
        
     }

}
