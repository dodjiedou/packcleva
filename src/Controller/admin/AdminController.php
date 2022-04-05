<?php

namespace App\Controller\admin;


use App\Entity\Personne;
use App\Entity\Prendre;
use App\Entity\Contracter;
use App\Entity\Classe;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */

class AdminController extends AbstractController
{
   

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $beneficiaire = count($this->getDoctrine()->getRepository(Beneficiaire::class)->findAll());
        $casDeMaladie =count($this->getDoctrine()->getRepository(Contracter::class)->findAll()) ;
        $casDeVaccination =count( $this->getDoctrine()->getRepository(Prendre::class)->findAll());
        $classe = count($this->getDoctrine()->getRepository(Classe::class)->findAll());
        //$nombreBeneficiaire = count($beneficiaires);
         //return $this->render('admin/index.html.twig',['beneficiaires' => $beneficiaires]);
        return $this->render('admin/index.html.twig',[
            'beneficiaire' => $beneficiaire,
            'casDeVaccination' => $casDeVaccination,
            'classe' => $classe,
            'casDeMaladie' => $casDeMaladie,
    ]);
    }
    
}
