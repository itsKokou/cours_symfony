<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Secteur;
use App\Entity\Direction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                "attr"=>[
                    "class"=>"inline-flex w-full px-4 h-10 bg-gray-50 dark:bg-gray-700 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block dark:border-gray-600 dark:placeholder-gray-400 dark:text-white",
                ],
                'label_attr'=> ['class'=> 'text-gray-900 dark:text-gray-400'],
            ])
            ->add('codeUO',TextType::class,[
                "attr"=>[
                    "class"=>"inline-flex w-full px-4 h-10 bg-gray-50 dark:bg-gray-700 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block dark:border-gray-600 dark:placeholder-gray-400 dark:text-white",
                ],
                'label_attr'=> ['class'=> 'text-gray-900 dark:text-gray-400'],
            ])
            ->add('direction',EntityType::class,[
                // looks for choices from this entity
                'class' => Direction::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
                "attr"=>[
                    "class"=>"inline-flex w-full px-4 h-10 max-h-fit bg-gray-50 dark:bg-gray-700 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block dark:border-gray-600 dark:placeholder-gray-400 dark:text-white",
                    "style"=>"justify-content: space-between;"
                ],
                'label_attr'=> ['class'=> 'text-gray-900 dark:text-gray-400'],
            ])
            ->add('agents',EntityType::class, [
                'class' => Agent::class,
                'choice_label' => 'nomComplet',
                'multiple' => true,
                'expanded' => false,
                "attr"=>[
                    "class"=>"selectAgents inline-flex w-full px-4 h-10 max-h-fit bg-gray-50 dark:bg-gray-700 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block dark:border-gray-600 dark:placeholder-gray-400 dark:text-white",
                    "style"=>"justify-content: space-between;",
                ],
                'label_attr'=> ['class'=> 'text-gray-900 dark:text-gray-400'],
            ])
            ->add('save',SubmitType::class, [
                'label'=> 'Enregistrer',
                "attr"=>[
                    "class"=>"px-4 py-2 text-sm font-medium leading-5 text-red-600 transition-colors duration-150 bg-transparent border border-red-600 rounded-lg hover:text-white hover:bg-red-600   focus:outline-none focus:shadow-outline-red",
                    "style"=>"margin-left:90%",
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteur::class,
        ]);
    }
}
