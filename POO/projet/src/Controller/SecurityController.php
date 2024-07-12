<?php

namespace App\Controller;

use App\Repository\AnneeScolaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,AnneeScolaireRepository $anneeScolaireRepository, SessionInterface $session): Response{
        if ($this->getUser()) {
            $annee = $anneeScolaireRepository->findAll();
            $session->set("annees", $annee);
            $session->set('anneeEncours',$anneeScolaireRepository->findOneBy(['isActive'=>1]));
            return $this->redirectToRoute('app_classe');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void {
        //$this->redirectToRoute("app_login");
    }
}
