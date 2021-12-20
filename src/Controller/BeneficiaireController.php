<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Beneficiaire;
use App\Form\BeneficiaireFormType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BeneficiaireController extends AbstractController
{

    /*
        /list_beneficiaire
        /creerbeneficiaire
        /showbeneficiaire/{num}
        /edit_beneficiaire
        /delete_beneficiaire/{num}
    */


    #[Route('/list_beneficiaire', name: 'list_beneficiaire')]
    public function index(): Response
    {
        $beneficiaires = $this->getDoctrine()
            ->getRepository(Beneficiaire::class)->findAll();
        return $this->render('beneficiaire/list_beneficiaire.html.twig',[
            'beneficiaires' => $beneficiaires]);
        
    }

    #[Route('/creerbeneficiaire', name: 'creerbeneficiaire')]
    public function new(Request $request): Response
    {
       $beneficiaire = new Beneficiaire();
        $personne = new Personne();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $beneficiaire = $form->getData();
            $entityManager->persist($beneficiaire);
            $entityManager->flush();
            return $this->redirectToRoute('creerbeneficiaire');
        }

        return $this->render('beneficiaire/creerbeneficiaire.html.twig', [
            'form' => $form->createView()]);
         
    }

    #[Route('/showbeneficiaire/{num}', name: 'showbeneficiaire')]
    public function show($num): Response
    {
        $benef = $this->getDoctrine()
            ->getRepository(Beneficiaire::class)->findOneBy(["numero"=>$num]);
            //$benef = $this->getDoctrine()
            //->getRepository(Beneficiaire::class)->find($id);
            
        return $this->render('beneficiaire/afficherbeneficiaire.html.twig', compact('benef'));
    }

    #[Route('/edit_beneficiaire', name: 'edit_beneficiaire')]
    public function edit(): Response
    {
        return $this->render('beneficiaire/edit_beneficiaire.html.twig');
    }

    #[Route('/delete_beneficiaire/{num}', name: 'delete_beneficiaire')]
    public function delete($num): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $benef = $this->getDoctrine()
            ->getRepository(Beneficiaire::class)->findOneBy(["numero"=>$num]);
        $entityManager->remove($benef);
        $entityManager->flush();
        $beneficiaires = $this->getDoctrine()
            ->getRepository(Beneficiaire::class)->findAll();
        return $this->render('beneficiaire/list_beneficiaire.html.twig',[
            'beneficiaires' => $beneficiaires]);
    }
}
