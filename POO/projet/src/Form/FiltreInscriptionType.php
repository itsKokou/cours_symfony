<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltreInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Classe',EntityType::class, [
            'required'=> false,
            'placeholder'=>"All",
            'class' => Classe::class,
            'choice_label' => 'libelle',
            'multiple' => false,
            'expanded' => false,
        ])
        ->add('save',SubmitType::class, [
            'label'=> 'Rechercher',
            "attr"=>[
                "class"=>"btn btn-light mt-2",
                "style"=>"margin-left:85%",
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}