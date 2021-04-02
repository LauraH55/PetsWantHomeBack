<?php

namespace App\Form;

use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Species;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // With our builder, we configurate our form's fields we want in based on our entity's fields.
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance :',
                'years' => range(date('Y'), date('Y') - 25),
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
            ->add('catCohabitation', CheckboxType::class, [
                'label' => 'Chats'
            ])
            ->add('dogCohabitation', CheckboxType::class, [
                'label' => 'Chiens'
            ])
            ->add('nacCohabitation', CheckboxType::class, [
                'label' => 'Nacs'
            ])
            ->add('childCohabitation', CheckboxType::class, [
                'label' => 'Enfants'
            ])
            ->add('unknownCohabitation', CheckboxType::class, [
                'label' => 'Non Testé / Ne sais pas'
            ])
            ->add('picture', FileType::class,  [
                // File type allow to download a file, here we configurate the FileType in annotations in the entity Animal
                'label' => 'Photo de l\'animal',
                'mapped' => false,
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'L\'animal est :',
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
                'label' => 'Description de l\'animal :',
            ])
            ->add('species', EntityType::class, [
                // The EntityType allow to associate the relation between entity's data in the form and save it
                'label' => 'Espèce :',
                'class' => Species::class,
                'multiple' => false,
                'expanded' => true,
                'choice_label' => 'name',
            ])
          
            ->add('race', EntityType::class, [
                'label' => 'Race :',
                'placeholder' => '-Vous pouvez sélectionner une race-',
                'class' => Race::class,
                'choice_label' => 'name',
                'multiple' => false,
                'empty_data' => '',
            ]);
            
            /* ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $animal = $event->getData();
                $form = $event->getForm();
                if ($animal != null && ($animal->getSpecies() != null || $animal->getRace() != null)) 
                {
                    $form->add('race', EntityType::class, [
                        'placeholder' => 'Vous pouvez sélectionner une race',
                        'class' => Race::class,
                        'choice_label' => 'name',
                        'multiple' => false,
                        'empty_data' => '']);
                
                }}); */  
            
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
