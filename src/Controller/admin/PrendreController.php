<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PrendreFormType;
use App\Entity\Prendre;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Form\RapportVaccinationType;


class PrendreController extends AbstractController
{

    /*
        /vaccination
        /rapport_vaccination
    */

    #[Route('/vaccination', name: 'vaccination')]
    public function vaccination(Request $request): Response
    {

        $prendre = new Prendre();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(PrendreFormType::class, $prendre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $prendre = $form->getData();
            $entityManager->persist($prendre);
            $entityManager->flush();
            return $this->redirectToRoute('vaccination');
        }

        return $this->render('admin/prendre/vaccination.html.twig', ['form' => $form->createView()]);
        
    }


     #[Route('/rapport_vaccination', name: 'rapport_vaccination')]
    public function rapport(Request $request): Response
    {

         $prendre = new Prendre();
        $form = $this->createForm(RapportVaccinationType::class, $prendre);
        $prendres =  $this->getDoctrine()
            ->getRepository(Prendre::class)->findAll();;
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $vaccin = $form->get("vaccin")->getData();
           
            $prendres = $this->getDoctrine()
            ->getRepository(Prendre::class)->findBy(["vaccin"=>$vaccin]);
            
            return $this->render('admin/prendre/rapport_vaccination.html.twig', ['form' => $form->createView(),'prendres'=> $prendres]);
        }
        
        return $this->render('admin/prendre/rapport_vaccination.html.twig', ['form' => $form->createView(),
            'prendres' => $prendres]);
       
        
    }
}
