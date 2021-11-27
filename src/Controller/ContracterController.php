<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContracterController extends AbstractController
{
    #[Route('/contracter', name: 'contracter')]
    public function index(): Response
    {
        return $this->render('contracter/index.html.twig', [
            'controller_name' => 'ContracterController',
        ]);
    }
}
