<?php

namespace App\Controller\admin;


use App\Entity\Personne;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\Form;
use App\Form\BeneficiaireFormType;
use App\Repository\BeneficiaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
   

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //$beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
         //return $this->render('admin/index.html.twig',['beneficiaires' => $beneficiaires]);
        return $this->render('admin/index.html.twig');
    }
    
}
