<?php

namespace App\Controller;

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

/**
 * @Route("/dashboard/beneficiaire")
 */
class BeneficiaireController extends AbstractController
{

    /**
     * @Route("/", name="beneficiaire_index", methods={"GET"})
     */
    public function index(BeneficiaireRepository $beneficiaireRepository): Response
    {
        return $this->render('dashboards/beneficiaire/index.html.twig', [
            'beneficiaires' => $beneficiaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="beneficiaire_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        BeneficiaireRepository $beneficiaireRepository
    ): Response
    {
        $beneficiaire = new Beneficiaire();
        // $beneficiaire->setAuthor($this->getUser());
        $form = $this->createForm(BeneficiaireType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($beneficiaire);
            $entityManager->flush();

            $this->addFlash("success","Bénéficiaire ".$beneficiaire->getPrenom()." ".$beneficiaire->getNom()." créé(e) avec succès !");

            return $this->redirectToRoute(
                'beneficiaire_index', 
                [
                    'beneficiaires' => $beneficiaireRepository->findAll()
                ], 
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('dashboards/beneficiaire/new.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{slug}", name="beneficiaire_show", methods={"GET"})
     */
    public function show(Beneficiaire $beneficiaire): Response
    {
        return $this->render('dashboards/beneficiaire/show.html.twig', [
            'beneficiaire' => $beneficiaire,
            // 'slug' => $beneficiaire->getSlug(),
        ]);
    }

    /**
     * @Route("/edit/{slug}", name="beneficiaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Beneficiaire $beneficiaire): Response
    {
        $form = $this->createForm(BeneficiaireType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success","Bénéficiaire ".$beneficiaire->getPrenom()." ".$beneficiaire->getNom()." modifié(e) avec succès !");

            return $this->redirectToRoute('beneficiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboards/beneficiaire/edit.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="beneficiaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Beneficiaire $beneficiaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$beneficiaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($beneficiaire);
            $entityManager->flush();
            $this->addFlash("success","Bénéficiaire ".$beneficiaire->getPrenom()." ".$beneficiaire->getNom()." supprimé(e) avec succès !");
        }

        return $this->redirectToRoute('beneficiaire_index', [], Response::HTTP_SEE_OTHER);
    }

}


// class BeneficiaireController extends AbstractController
// {

//     /*
//         /list_beneficiaire
//         /creerbeneficiaire
//         /showbeneficiaire/{num}
//         /edit_beneficiaire
//         /delete_beneficiaire/{num}
//     */


//     #[Route('/list_beneficiaire', name: 'list_beneficiaire')]
//     public function index(): Response
//     {
//         $beneficiaires = $this->getDoctrine()
//             ->getRepository(Beneficiaire::class)->findAll();
//         return $this->render('dashboards/beneficiaire/list_beneficiaire.html.twig',[
//             'beneficiaires' => $beneficiaires]);
        
//     }

//     #[Route('/creerbeneficiaire', name: 'creerbeneficiaire')]
//     public function new(Request $request): Response
//     {
//        $beneficiaire = new Beneficiaire();
//         $personne = new Personne();
//         $entityManager = $this->getDoctrine()->getManager();

//         $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);

//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {

//             $beneficiaire = $form->getData();
//             $entityManager->persist($beneficiaire);
//             $entityManager->flush();
//             return $this->redirectToRoute('creerbeneficiaire');
//         }

//         return $this->render('dashboards/beneficiaire/creerbeneficiaire.html.twig', [
//             'form' => $form->createView()]);
         
//     }

//     #[Route('/showbeneficiaire/{num}', name: 'showbeneficiaire')]
//     public function show($num): Response
//     {
//         $benef = $this->getDoctrine()
//             ->getRepository(Beneficiaire::class)->findOneBy(["numero"=>$num]);
//             //$benef = $this->getDoctrine()
//             //->getRepository(Beneficiaire::class)->find($id);
            
//         return $this->render('dashboards/beneficiaire/afficherbeneficiaire.html.twig', compact('benef'));
//     }

//     #[Route('/edit_beneficiaire', name: 'edit_beneficiaire')]
//     public function edit(): Response
//     {
//         return $this->render('dashboards/beneficiaire/edit_beneficiaire.html.twig');
//     }

//     #[Route('/delete_beneficiaire/{num}', name: 'delete_beneficiaire')]
//     public function delete($num): Response
//     {
//         $entityManager = $this->getDoctrine()->getManager();
//         $benef = $this->getDoctrine()
//             ->getRepository(Beneficiaire::class)->findOneBy(["numero"=>$num]);
//         $entityManager->remove($benef);
//         $entityManager->flush();
//         $beneficiaires = $this->getDoctrine()
//             ->getRepository(Beneficiaire::class)->findAll();
//         return $this->render('dashboards/beneficiaire/list_beneficiaire.html.twig',[
//             'beneficiaires' => $beneficiaires]);
//     }
// }


