<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeneficiaireController extends AbstractController
{
    #[Route('/beneficiaire', name: 'beneficiaire')]
    public function index(): Response
    {
        return $this->render('beneficiaire/index.html.twig', [
            'controller_name' => 'BeneficiaireController',
        ]);
    }
}
