<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'categorie')]
    public function index(): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    #[Route('/addcategorie', name: 'addcategorie')]
    public function ajouterCours(Request $request): Response
    {
        $categorie = new Categorie();
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)->findAll();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cours = $form->getData();
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('addcategorie');
        }
       
        return $this->render('admin/categorie/addcategorie.html.twig',[
            'form' => $form->createView(),
            'categories'=>$categories]);
        
    }

}
