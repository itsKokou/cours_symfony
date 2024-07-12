<?php

namespace App\Controller;

use App\Form\FiltreInscriptionType;
use App\Repository\ClasseRepository;
use App\Repository\InscriptionRepository;
use App\Repository\AnneeScolaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InscriptionController extends AbstractController{
    private array $selected=[];

    #[Route('/inscription', name: 'app_inscription')]
    public function index(SessionInterface $session,PaginatorInterface $paginator, Request $request,InscriptionRepository $inscriptionRepository,AnneeScolaireRepository $anneeScolaireRepository,ClasseRepository $classeRepository): Response{

        $form = $this->createForm(FiltreInscriptionType::class);
        $form->handleRequest($request);
        $this->selected['anneeScolaire']=$session->get('anneeEncours')->getId();
        $classe = null;
        // if ($form->isSubmitted()) { 
            if($form->get("Classe")->getData()!=null){
                $classe=$form->get("Classe")->getData()->getId();
            }           
            $this->selected['classe']=$classe;
            $session->set('selected',$this->selected);
        // }
        $page=$request->query->get("page",1);
        if($page>1 && $session->get('selected')!=null){
            $this->selected=$session->get('selected');
        }
        //filtre par classe 
        $queryInscriptions = $inscriptionRepository->prepareQueryForpagination($this->selected);
        $pagination = $paginator->paginate(
            $queryInscriptions, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $this->getParameter('PAGE_LIMIT') /*limit per page*/
        );
        
        return $this->render('inscription/index.html.twig', [
            "pagination" => $pagination,
            'form'=> $form->createView()
        ]);
    }

    #[Route('/inscription/save{id?}', name: 'app_inscription_save')]
    public function save(){

    }
}
