<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VaccinController extends AbstractController
{
    #[Route('/vaccin', name: 'vaccin')]
    public function index(): Response
    {
        return $this->render('vaccin/index.html.twig', [
            'controller_name' => 'VaccinController',
        ]);
    }
}
