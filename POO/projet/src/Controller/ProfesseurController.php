<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\FiltreProfType;
use App\Form\ProfesseurType;
use App\Repository\ClasseRepository;
use App\Repository\ModuleRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfesseurController extends AbstractController{
    private array $selected=[];

    #[Route('/professeur', name: 'app_professeur',methods:["POST","GET"])]
    public function index(PaginatorInterface $paginator,Request $request ,ProfesseurRepository $professeurRepository,
                    ClasseRepository $classeRepository,ModuleRepository $moduleRepository): Response {
        
        $form = $this->createForm(FiltreProfType::class);
        $form->handleRequest($request);//Prends les valeur du forme et le met dans prof
        $session = $request->getSession();
        $page=$request->query->get("page",1);
        $module = null;
        $classe = null;
        if ($form->isSubmitted()) { 
            if($form->get("Classe")->getData()!=null){
                $classe=$form->get("Classe")->getData()->getId();
            }           
            if($form->get("Module")->getData()!=null){
                $module=$form->get("Module")->getData()->getId();
            }  
            
            $this->selected=[
                'classe'=>$classe,
                'module'=>$module
            ];
            $session->set('selected',$this->selected);
        }
        if($page>1 && $session->get('selected')!=null){
             $this->selected=$session->get('selected');
        }

        $query = $professeurRepository->prepareQueryForpagination($this->selected);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $this->getParameter('PAGE_LIMIT') /*limit per page*/
        );
        
        return $this->render('professeur/index.html.twig', [
            'pagination' => $pagination,
            'form'=> $form->createView()
        ] );
    }
    

    //Ajout Et La modification
    //'/professeur/save/{id?} = ce path contient un parametre qui s'appelle id; ?= parametre facultatif
    #[Route('/professeur/save/{id?}', name: 'app_professeur_save',methods:["POST","GET"])]
    public function save($id,Request $request ,ProfesseurRepository $professeurRepository, EntityManagerInterface $manager,UserPasswordHasherInterface $encoder): Response {
        if ($id==null) {
            $prof = new Professeur();
        }else{
            $prof = $professeurRepository->find($id);
        }
        //$prof->setNomComplet("Kokou Ok");
        //Liaison de donnée entre formulaire et objet de type professeur
        //Mapping ou un Binding
        $form = $this->createForm(ProfesseurType::class,$prof);
        $form->handleRequest($request);//Prends les valeur du forme et le met dans prof
        if ($form->isSubmitted() && $form->isValid()) {
            $prof->setPassword($encoder->hashPassword($prof, $prof->getPassword()));
            $manager->persist($prof);
            $manager->flush();
        }
        return $this->render('professeur/form.html.twig', [
            'form'=> $form->createView(),//form est un objet, createView genere son code html
        ]);
    }

}