<?php

namespace App\Controller;

use App\Repository\AnneeScolaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnneeScolaireController extends AbstractController
{
    #[Route('/annee/scolaire', name: 'app_annee_scolaire')]
    public function index(): Response
    {
        return $this->render('annee_scolaire/index.html.twig', [
            'controller_name' => 'AnneeScolaireController',
        ]);
    }

    private function changeAnneeInSession(array $anneesInSession,int $id):array{
        foreach ($anneesInSession as $key=> $annee) {
            if($annee->getId()==$id){
                $anneesInSession[$key]->setIsActive(true);
            }else{
                $anneesInSession[$key]->setIsActive(false);
            }
        }
        return $anneesInSession;
    }

    #[Route('/annee/change', name: 'app_annee_scolaire_change')]
    public function changeAnneeEncours(Request $request, AnneeScolaireRepository $repo,SessionInterface $session): Response {
        
        if($request->isXmlHttpRequest() || $request->query->get('id')!=0) {//requete asynchrone
            $id =(int) $request->query->get('id');
            $anneesInSession = $session->get("annees");
            $anneeEncours = $repo->find($id );//on
            $session->set('anneeEncours', $anneeEncours);
            $session->set('annees', $this->changeAnneeInSession($anneesInSession, $id));
        }
        return new JsonResponse($this->generateUrl('app_inscription'));
    }
}