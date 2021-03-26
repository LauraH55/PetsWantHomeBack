<?php

namespace App\Form;

use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Species;
use App\Entity\AnimalRepository;
use App\Repository\RaceRepository;
use App\Repository\SpeciesRepository;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // With our builder, we configurate our form's fields we want in based on our entity's fields.
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                // In ChoiceType we choose our value in a array
                'choices' => [
                    'Mâle' => 1,
                    'Femelle' => 2,
                ],
                // Here we indicate if the choices can be multiple or not with true or false, here we can select an only value 
                'multiple' => false,
                // Here we choose the view of the field, expanded => true show all array's data by checkboxes
                'expanded' => true,
            ])
            ->add('cohabitation', ChoiceType::class, [
                'label' => 'L\'animal s\'entend bien avec',
                'choices' => [
                    'Enfants' => 1,
                    'Chats' => 2,
                    'Chiens' => 3,
                    'Tous' => 4,
                    'Ne sait pas' => 5,
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('picture', FileType::class,  [
                // File type allow to download a file, here we configurate the FileType in annotations in the entity Animal
                'label' => 'Photo de l\'animal',
                'required' => false,
                'data_class' => null,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'L\'animal est',
                'choices' => [
                    'À adopter' => 1,
                    'Adopté' => 2,
                    /* V2 'Perdu' => 3,
                        'Trouvé' => 4, */
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'animal'
            ])
            ->add('species', EntityType::class, [
                // The EntityType allow to associate the relation between entity's data in the form and save it
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
