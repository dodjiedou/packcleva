<?php

namespace App\Security;


use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Controller\admin\SecurityController;


class LoginAuthenticator extends AbstractAuthenticator
{
  
     private $userRepository;
     private $urlGenerator;
     
     public function __construct(UserRepository $userRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->userRepository = $userRepository;
        $this->urlGenerator = $urlGenerator;
    }

  /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route')==='app_login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $user=$this->userRepository->findOneByEmail($request->request->get('email'));
        $request->getSession()->set(SecurityController::LAST_EMAIL,$request->request->get("email"));
        
        //$apiToken = $request->headers->get('X-AUTH-TOKEN');
        if (! $user) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new //
            CustomUserMessageAuthenticationException('Email not found');
            //throw new UserNameNotFoundException;
        }

        return new Passport(new UserBadge($request->request->get('email')),
            new PasswordCredentials($request->request->get('password')));



    }
    

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        //dd('success');

        return new RedirectResponse( $this->urlGenerator->generate('admin'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        /*$data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ]; 

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
        //dd('echec');*/

        $request->getSession()->getFlashBag()->add("error","Email ou mot da passe incorect");
        return new RedirectResponse( $this->urlGenerator->generate('app_login'));
    }
    
    
}
