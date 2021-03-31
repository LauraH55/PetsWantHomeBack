<?php

namespace App\Form;

use App\Entity\Shelter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ShelterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse :'
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du Refuge :'
            ])
            ->add('picture', FileType::class,  [
                // File type allow to download a file, here we configurate the FileType in annotations in the entity Shelter
                'label' => 'Photo du refuge :',
                'data_class' => null,
            ])
            /* V2
            ->add('rnaNumber') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shelter::class,
        ]);
    }
}
