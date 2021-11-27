<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrendreController extends AbstractController
{
    #[Route('/prendre', name: 'prendre')]
    public function index(): Response
    {
        return $this->render('prendre/index.html.twig', [
            'controller_name' => 'PrendreController',
        ]);
    }
}
