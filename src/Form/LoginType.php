<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Email du Refuge :'
        ])
            /* ->add('password', PasswordType::class, [
                'label' => 'Nouveau Mot de Passe',
                'empty_data' => '',
            ]) */
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field'],
                'required' => false,
                'label' => 'Mot de passe *',
                'help' => 'Entre 8 et 16 caractères, une majuscule, une minuscule, un chiffre, $@%*+-_!',
                'constraints' => [
                    new Regex('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/'),
                    new Length([
                        'min' => 8,
                        'max' => 16,])
                ]],
                'required' => true,
                'first_options'  => ['label' => 'Nouveau mot de passe :'],
                'second_options' => ['label' => 'Confirmation du mot de passe :'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
