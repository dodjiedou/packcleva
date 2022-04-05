<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use app\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;





class SecurityController extends AbstractController
{

    public const LAST_EMAIL="old_email";
    
    #[Route('/security/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('admin/security/login.html.twig');
    }
    #[Route('/security/logout', name: 'app_logout' )]
     public function logout()
    {
       throw new \LogicException("This method can be blank - it will be intercepted by the logout key on your firewall. ");
       
    }

     #[Route('/security/register', name: 'register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        
         $entityManager = $this->getDoctrine()->getManager();
         
         $form = $this->createForm(UserType::class, $user);
        

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
        
             $user->setRoles($form->get('roles')->getData());
             $user->setEmail($form->get('email')->getData());
             $user->setUserName($form->get('userName')->getData());
            $pleinPasswoerd=$form->get('Pleinpassword')->getData();
            $user->setPassword($passwordEncoder->encodePassword($user,$pleinPasswoerd)) ;
             $entityManager->persist($user);
             $entityManager->flush();   
            $this->addFlash("ajouteUser", "Enregistrement éffectué avec succès !");
             return $this->redirectToRoute('register');
         }

        return $this->render('admin/security/register.html.twig',
            ['form' => $form->createView()] );
    }
}
