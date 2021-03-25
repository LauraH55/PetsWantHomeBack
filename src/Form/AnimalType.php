<?php

namespace App\Form;

use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Species;
use App\Entity\AnimalRepository;
use App\Repository\RaceRepository;
use App\Repository\SpeciesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Mime\MimeTypes;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Mâle' => 1,
                    'Femelle' => 2,
                ],
                'multiple' => false,
                'expanded' => true,
            ])

            ->add('cohabitation', ChoiceType::class, [
                'label' => 'L\'animal s\'entend bien avec',
                'choices' => [
                    'Enfants' => 1,
                    'Chats' => 2,
                    'Chiens' => 3,
                    'Ne sait pas' => 4,
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('picture', FileType::class,  [
                'label' => 'Photo de l\'animal',
                'required'=> false,
                'data_class' => null,
            ])
            ->add('status', ChoiceType::class, [
                    'label' => 'L\'animal est',
                    'choices' => [
                        'À adopter' => 1,
                        'Adopté' => 2,
                        /* 'Perdu' => 3,
                        'Trouvé' => 4, */ 
                    ],
                    'multiple' => false,
                    'expanded' => true,
            ]) 
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'animal'
                ])
                ->add('species', EntityType::class, [
                    'class' => Species::class,
                    'multiple' => false,
                    'expanded' => true,
                    'choice_label' => 'name',
                ])
                ->add('race', EntityType::class, [
                    'class' => Race::class,
                    'choice_label' => 'name',      
                    'multiple' => false,
                ]);
    }
                
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }



}