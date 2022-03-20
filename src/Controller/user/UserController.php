<?php

namespace App\Controller\user;


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


class UserController extends AbstractController
{
    #[Route('/', name: 'user')]
    public function index(): Response
    {
      
        return $this->render('user/index.html.twig');
    }

     #[Route('/apropos', name: 'apropos')]
    public function apropos(): Response
    {
      
        return $this->render('user/about.html.twig');
    }


     #[Route('/classes', name: 'classes')]
    public function classes(): Response
    {
      
        return $this->render('user/classes.html.twig');
    }


     #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
      
        return $this->render('user/contact.html.twig');
    }
}
