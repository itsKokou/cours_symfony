<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use App\Repository\FiliereRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseController extends AbstractController{
    private const LIMIT=3;
    
    #[Route('/classe', name: 'app_classe',methods:["POST","GET"])]
    public function index(Request $request ,ClasseRepository $classeRepository,
                    NiveauRepository $niveauRepository,FiliereRepository $filiereRepository): Response {
        
        $session = $request->getSession();
        $page=$request->query->get("page",1);
        $selected=[];
        if($request->request->has("btn_save") ){
            $filiere=$request->request->get("filiere");
            $niveau=$request->request->get("niveau");
            $selected=[
                'filiere'=>$filiere,
                'niveau'=>$niveau
            ];
            $session->set('selected',$selected);
        }

        if($page>1 && $session->get('selected')!=null){
            $selected=$session->get('selected');
        }


        $count = $classeRepository->countClasseByFiltre($selected);
        $nbrePage=ceil($count/self::LIMIT);
        
        return $this->render('classe/index.html.twig', [
            'page' => $page,
            'nbrePage' => $nbrePage,
            'selectedValue' => $selected,
            'filieres' => $filiereRepository->findBy(['isArchived'=> false]),
            'niveaux' =>$niveauRepository->findBy(['isArchived'=> false]),
            'classesNotArchived' =>$classeRepository->findPaginateByFiltre($page,self::LIMIT,$selected),
        ] );
    }

    #[Route('/classe/save/{id?}', name: 'app_classe_save',methods:["POST","GET"])]
    public function save($id,Request $request ,ClasseRepository $classeRepository, EntityManagerInterface $manager): Response {
        if ($id==null) {
            $classe = new Classe();
        }else{
            $classe = $classeRepository->find($id);
        }
        //$classe->setLibelle("Kokou");
        //Liaison de donnée entre formulaire et objet de type professeur
        //Mapping ou un Binding
        $form = $this->createForm(ClasseType::class,$classe);
        $form->handleRequest($request);//Prends les valeur du forme et le met dans classe
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($classe);
            $manager->flush();
        }
        return $this->render('classe/form.html.twig', [
            'form'=> $form->createView(),//form est un objet, createView genere son code html
        ]);
    }
}
