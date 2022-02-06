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
use App\Form\LettreType;

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
    #[Route('/create/question', name: 'create_question')]
    public function question(Request $request): Response
    {


        $question = new Question();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('create_question');
        }

        
         return $this->render('admin/lettre/create_question.html.twig',[
            'form' => $form->createView()]);
       
    }

    
    #[Route('/create/reponse', name: 'create_reponse')]
    public function reponse(Request $request): Response
    {


        $reponse = new Reponse();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reponse = $form->getData();
            $entityManager->persist($reponse);
            $entityManager->flush();
            return $this->redirectToRoute('create_reponse');
        }

        return $this->render('admin/lettre/create_reponse.html.twig',[
            'form' => $form->createView()]);
       
    }
}
