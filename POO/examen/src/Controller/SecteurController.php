<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Repository\AgentRepository;
use App\Repository\SecteurRepository;
use App\Repository\DirectionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecteurController extends AbstractController
{
    #[Route('/secteur', name: 'app_secteur')]
    public function index(SecteurRepository $secteurRepository, DirectionRepository $directionRepository, AgentRepository $agentRepository, Session $session): Response
    {
        $agent = null;
        $direction = null;
        if($session->has("directionID")){
            $direction = (int)$session->get("directionID");
        }
        if($session->has("agentID")){
            $agent = (int)$session->get("agentID");
        }
        $selectedvalue = [
            "direction" => $direction,
            "agent" => $agent,
        ];
        $htmlAgent = null;
        if($session->has("secteurID")){
            $secteur = $secteurRepository->find((int)$session->get("secteurID"));
            $session->remove("secteurID");
            $htmlAgent = $this->renderView("secteur/detailAgent.html.twig",["secteur"=>$secteur,"agents"=>$secteur->getAgents()]);
        }
        $secteurs = $secteurRepository->findSecteursByDirectionAndAgent($selectedvalue);
        $directions = $directionRepository->findAll();
        $agents = $agentRepository->findAll();
        return $this->render('secteur/index.html.twig', [
            'secteurs' => $secteurs,
            'directions' => $directions,
            'agents' => $agents,
            'selectedValue' => $selectedvalue,
            'htmlAgent' => $htmlAgent,
        ]);
    }

    #[Route('/secteur/filtre/direction/{idD?}', name: 'app_secteur_filtre_direction')]
    public function filtreByDirection($idD,Request $request, Session $session): Response
    {
        if($request->isXmlHttpRequest() || $idD !=0){
            $session->set("directionID",(int)$idD);
        }else{
            $session->remove("directionID");
        }
       return new JsonResponse($this->generateUrl('app_secteur'));
    }

    #[Route('/secteur/agent/{idA?}', name: 'app_secteur_filtre_agent')]
    public function filtreByAgent($idA,Request $request, Session $session): Response
    {
        if($request->isXmlHttpRequest() || $idA !=0){
            $session->set("agentID",(int)$idA);
        }else{
            $session->remove("agentID");
        }
       return new JsonResponse($this->generateUrl('app_secteur'));
    }

    #[Route('/secteur/details/{id?}', name: 'app_secteur_agents')]
    public function agentDuSecteur($id,Request $request, Session $session): Response
    {
        if($request->isXmlHttpRequest() || $id !=0){
            $session->set("secteurID",(int)$id);
        }
       return $this->redirectToRoute('app_secteur');
    }

    #[Route('/secteur/save', name: 'app_secteur_save')]
    public function save(Request $request): Response
    {
        $secteur = new Secteur();
        $form = $this->createForm(SecteurType::class,$secteur);
        $form->handleRequest($request);
        return $this->render('secteur/form.html.twig', [
            'form' => $form,
        ]);
    }
}
