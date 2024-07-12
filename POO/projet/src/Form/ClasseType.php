<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',null,[
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('filiere',null,[
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('niveau',null,[
                "attr"=>[
                    "class"=>"mb-2",
                ]
            ])
            ->add('save',SubmitType::class, [
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
            'data_class' => Classe::class,
        ]);
    }
}
