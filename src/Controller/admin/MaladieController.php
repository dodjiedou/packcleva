<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MaladieType;
use App\Entity\Maladie;
use app\Form\RapportType;
use App\Entity\Contracter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */


class MaladieController extends AbstractController
{
    #[Route('/addmaladie', name: 'addmaladie')]
    public function index(Request $request): Response
    {
         $maladie = new Maladie();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(MaladieType::class, $maladie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $maladie = $form->getData();
            $entityManager->persist($maladie);
            $entityManager->flush();
            return $this->redirectToRoute('addmaladie');
        }
       
        return $this->render('admin/maladie/add_maladie.html.twig',[
            'form' => $form->createView()]);
    }


    
}
