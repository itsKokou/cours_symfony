<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Module;
use App\Entity\Professeur;
use App\Repository\ProfesseurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesseurType extends AbstractType{
    private ProfesseurRepository $professeurRepository;

    public function __construct(ProfesseurRepository $professeurRepository){
       $this->professeurRepository = $professeurRepository;
    }    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',null,[
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('password',PasswordType::class,[
                "required"=> true,
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('nomComplet',null,[
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('grade',ChoiceType::class,[
                "choices"=>$this->professeurRepository->getGrades(),
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('modules',EntityType::class, [
                // looks for choices from this entity
                'class' => Module::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'libelle',
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
                "attr"=>[
                    "class"=>"mb-2 d-flex",
                    "style"=>"justify-content: space-between;",
                ]
            ])
            ->add('classes',EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
                "attr"=>[
                    "class"=>"mb-2 d-flex",
                    "style"=>"justify-content: space-between;",
                ]
            ])
            ->add('save',SubmitType::Class, [
                'label'=> 'Enregistrer',
                "attr"=>[
                    "class"=>"btn btn-outline-danger mt-2",
                    "style"=>"margin-left:85%",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
