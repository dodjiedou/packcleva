<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VaccinType;
use App\Entity\Vaccin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */

class VaccinController extends AbstractController
{
    #[Route('/addvaccin', name: 'addvaccin')]
    public function index(Request $request): Response
    {
        $vaccin = new Vaccin();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(VaccinType::class, $vaccin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vaccin = $form->getData();
            $entityManager->persist($vaccin);
            $entityManager->flush();
            return $this->redirectToRoute('addvaccin');
        }
       
        
        return $this->render('admin/vaccin/add_vaccin.html.twig',['form' => $form->createView()]);
    }
}
